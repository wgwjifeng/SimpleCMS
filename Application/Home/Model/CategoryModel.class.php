<?php

namespace Home\Model;
use Think\Model;

class CategoryModel extends Model{

	protected function _after_find(&$data, $options){
        /* 分割模型 */
        if($data['models']){
            $data['models'] = unserialize($data['models']);
            $data['children_models'] = unserialize($data['children_models']);
        }

        /* 还原扩展数据 */
        if($data['extend_id']){
            $data['extend'] = D("Extend")->find($data['extend_id']);
        }

        $data['parent'] = NULL;
        if($data['pid']) {
            // 递归获取了所有parent
            $data['parent'] = D("Category")->getById($data['pid']);
            $data['parent_title'] = $data['parent']['title'];
        }

        if(!$data['thumb']) {
            if($data['parent']['thumb']) {
                $data['thumb'] = $data['parent']['thumb'];
            } else if($data['parent']['parent']['thumb']) {
                $data['thumb'] = $data['parent']['parent']['thumb'];
            }
        }
	}

	public function info($id, $field = true){
        $cache_key = 'category_info_' . $id;
        if($cat = S($cache_key)) {
            return $cat;
        }

		$map = array();
		if(is_numeric($id)){ //通过ID查询
			$map['id'] = $id;
		} else { //通过标识查询
			$map['name'] = $id;
		}
		$cat = $this->where($map)->find();
        S($cache_key, $cat);
        return $cat;
	}

    /*
     * is_tree 是否显示树型
     */
    public function getTree($id = 0, $field = true, $condition = false, $is_tree=true){
        $cache_key = 'category_tree_' . $id . serialize($field) . serialize($condition);
        if($x = S($cache_key)) {
            return $x;
        }
        /* 获取当前分类信息 */
        if($id){
           $info = $this->info($id);
           $id   = $info['id'];
        }

        /* 获取所有分类 */
        $map  = array('status' => 1);
        if($condition) {
            $map = array_merge($map,$condition);
        }
        $list = $this->field($field)->where($map)->order('sort, id')->select();
        if($is_tree) {
            $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);
        }else{
            $list = $this->getRichInfo($list);
        }

        /* 获取返回数据 */
        if(isset($info)){ //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }
        S($cache_key, $info);
		return $info;
	}

	public function getSameLevel($id, $field = true){
		$info = $this->info($id, 'pid');
		$map = array('pid' => $info['pid'], 'status' => 1);
		return $this->field($field)->where($map)->order('sort')->select();
	}

	/**
	 * 获取指定分类子分类ID
	 * @param  string $cate 分类ID
	 * @return string       id列表
	 *  如果$param === true 就把自己也返回
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function getChildrenId($cate,$param = false){
		$field = 'id,name,pid,title';
		$category = D('Category')->getTree($cate, $field);
		$ids = array();
		foreach ($category['_'] as $key => $value) {
			$ids[] = $value['id'];
		}
		if($param === true) {
			$ids[] = $cate;
		}
		// return implode(',', $ids);
		return $ids;
	}

    /**
    *获取指定分类id的子信息
    */
    public function getChildren($pid,$param = false){
        if(!$pid) return NULL;
        if(!is_numeric($pid)) {
            $f['name'] = $pid;
            $pid = M('Category')->where($f)->getField('id');
        }

        $children = M('Category')->where(array('pid'=>intval($pid)))->order('sort, id')->select();

        return $children;
    }

	/**
	 * 获得父级id
	 * param ture的时候假如为顶级栏目，就把自己返回
	 */
	public function getParentId($id,$param = false) {
		if(!$id) return NULL;

		$pid = $this->where(array('id'=>$id))->getField('pid');
		if($pid == 0) {
			if($param === true) {
				$pid = $id;
			}
		}else{
			$pid = $pid;
		}
		return $pid;
	}

    public function set_current_nav($category) {

        if($category['parent']['parent']) {
            $category_id = $category['parent']['parent']['id'];
        } else if($category['parent']) {
            $category_id = $category['parent']['id'];
        } else {
            $category_id = $category['id'];
        }

        $data['root_navbar'] = D("Category")->getTree($category_id,'',array('is_menu'=>1));

        $data['current_navbar'] = D("Category")->getTree($category['id'],'',array('is_menu'=>1));
        return $data;
    }

    public function getRichInfo($cates){
        if(!$cates) return null;
        foreach ($cates as $key => $cate) {
            if($cate['enable_contribute'] == 2) {
                $cates[$key]['children_contents'] = D('Content')->getPages(array('category_id' => $cate['id']));
            }
            $cates[$key]['extend'] = D("Extend")->find($cate['extend_id']);
        }
        return $cates;
    }

    public function getCategoryById($id, $order=false) {
        if(!$id) return NULL;

        $is_single = 0;
        if(is_numeric($id)) {
            $map['id']= $id;
            $is_single = 1;
        }elseif(is_array($id)) {
            foreach($id as $k =>$v) {
                if(is_numeric($v)){
                    $cat = $this->where(array('id'=>$v))->find();
                    if($cat){
                        $cats[] = $cat;
                    }
                }else {
                    $cat = $this->where(array('name'=>$v))->find();
                    if($cat){
                        $cats[] = $cat;
                    }
                }
            }
            return $cats;
        }else {
            $map['name'] = $id;
            $is_single = 1;
        }
        if(!$order) {
            $order = "sort asc";
        }
        $cats = $this->where($map)->order($order)->select();
        if($cats && $is_single) {
            return $cats[0];
        }
        return $cats;
    }

    public static $parents = array();
    public function getParents($cat_id) {
        $res = array();
        $field = "id,pid,name,title,link";
        $parent = M('Category')->where(array('id'=>$cat_id))->field($field)->find();
        if(!$parent['link']) {
            $parent['link'] = '/category/'.$parent['id'];
        }
        self::$parents[] = $parent;

        if($parent['pid']) {
            return self::$parents[] = $this->getParents($parent['pid']);
        }
        return self::$parents;
    }

    public function getCategorysHasContents($cid = array(),$content_num,$condition,$order=false) {
        $category_trees = $this->getTree($cid);
        if($category_trees){
            $cats = $category_trees['_'];
        }

        if(!$order) {
            $order = "publish_time desc";
        }
        $count_condition_content = 0;
        foreach($cats as $k => $cat) {
            $cats[$k]['pages'] = D('Content')->getPagesByTypeId($cat['id'],1,$content_num,$condition,'',$order);
            $count_condition_content += count($cats[$k]['pages']);
        }
        $cats['count_condition_content'] = $count_condition_content;
        return $cats;
    }

}
