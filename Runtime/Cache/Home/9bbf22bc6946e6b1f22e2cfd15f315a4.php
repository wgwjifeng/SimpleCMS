<?php if (!defined('THINK_PATH')) exit();?><!Doctype html><html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta charset="UTF-8">
<?php if($info): ?><title><?php echo ($info['title']); ?>-<?php echo C('site_title');?></title>
<?php elseif($category): ?>
    <title><?php echo ($category['title']); ?>-<?php echo C('site_title');?></title>
<?php else: ?>
    <title><?php echo C('site_title');?></title><?php endif; ?>
<?php if($info): ?><meta name="description" content="<?php echo ($info['title']); ?>" />
<meta name="keywords" content="<?php echo ($info['title']); ?>" />
<?php elseif($category): ?>
    <?php if($category['keywords']): ?><meta name="description" content="<?php echo ($category['keywords']); ?>" />
    <?php else: ?>
    <meta name="description" content="<?php echo ($category['title']); ?>" /><?php endif; ?>

    <?php if($category['description']): ?><meta name="description" content="<?php echo ($category['description']); ?>" />
    <?php else: ?>
    <meta name="description" content="<?php echo ($category['title']); ?>" /><?php endif; ?>
<?php else: ?>
<meta name="description" content="<?php echo C('site_description');?>" />
<meta name="keywords" content="<?php echo C('site_keyword');?>" /><?php endif; ?>

<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="shortcut icon" href="/Application/Home/View/lingshan/styles/css/images/favicon.ico" />
<link href="/Public/Static/bootstrap3/css/bootstrap.css" rel="stylesheet">
<link href="/Application/Home/View/lingshan/styles/css/style.css" rel="stylesheet">
<link href="/Application/Home/View/lingshan/styles/css/gallery.css" rel="stylesheet">
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/jquery.js"></script>
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/jquery.gallery.js"></script>
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/modernizr.custom..js"></script>
<script type="text/javascript" src="/Application/Home/View/lingshan/styles/js/main.js"></script>
<script type="text/javascript" src="/Public/Static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="top">
    <div class="container">
        <div class="logo"><a href="/"><img src="/Application/Home/View/lingshan/styles/css/images/logo.png" alt="<?php echo C('site_title');?>"/></a></div>
        <div class="logo_small"><a href="/"><img src="/Application/Home/View/lingshan/styles/css/images/logo_small.png" alt="<?php echo C('site_title');?>"/></a></div>
        <div class="top_nav">
            <div class="list">
                <?php $menu = D('Category')->getTree(0,'',array('is_menu'=>1));if(false)var_dump($menu);echo '<ul class="ul_level1 nav nav-pills nav_ul dropdown">';?><li class="banner_index <?php if($index): ?>active<?php endif; ?>" ><a href="/" >首页</a></li><?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lev1): $mod = ($i % 2 );++$i;?><li class="dropdown <?php if( $root_navbar['id'] == $lev1["id"] ): ?>active<?php endif; ?> banner_<?php echo ($lev1["name"]); ?>"><?php if($lev1["type"] == 3): ?><a href="<?php echo ($lev1["extralink"]); ?>" <?php if($lev1['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev1["title"]); ?></a><?php else: ?><a href="#" <?php if($lev1['link_target']): ?>onclick="window.open('<?php echo ($lev1["link"]); ?>')" <?php else: ?> onclick="window.location.href='<?php echo ($lev1["link"]); ?>'"<?php endif; ?>  class="dropdown-toggle" data-toggle="dropdown" id="drop<?php echo ($lev1['id']); ?>"><?php echo ($lev1["title"]); ?></a><?php endif; if($lev1['_']): ?><ul class="dropdown-menu" role="menu" aria-labelledby="drop<?php echo ($lev1['id']); ?>"><?php if(is_array($lev1['_'])): foreach($lev1['_'] as $key=>$lev2): ?><li><?php if($lev2["type"] == 3): ?><a href="<?php echo ($lev2["extralink"]); ?>" <?php if($lev1['link_target']): ?>target='_blank'<?php endif; ?>><?php echo ($lev2["title"]); ?></a><?php else: ?><a href="<?php echo ($lev2["link"]); ?>" <?php if($lev2['link_target']): ?>target='_blank'<?php endif; ?> ><?php echo ($lev2["title"]); ?></a><?php endif; ?></li><?php endforeach; endif; ?></ul><?php endif; ?></li><?php endforeach; endif; else: echo "" ;endif; echo "</ul>"; ?>
            </div>
        </div>
        <form class="search" action="/search/index">
            <div class="input"><input name="skey" id="search"  class="span6" type="text" value="<?php echo ($skey); ?>"></div>
            <div class="bt"><input type="image" class="sicon" title="搜索" alt="搜索" src="/Application/Home/View/lingshan/styles/css/images/search.png"></div>
            <div class="clear"></div>
        </form>
    </div>
</div>

    <?php
 $key_words = I("get.key_words"); ?>
<div class="bandlist margin-nav">
    <?php  $default_banner = D('Banner')->getBannerByName('default_banner'); $rand = rand(0,count($default_banner)-1); ?>
<?php if($category['banner']): ?><div class="banner" style="background-image:url('<?php echo thumb($category['banner'],0, 400);?>')">
    </div>
<?php elseif($category['parent']['thumb']): ?>
    <div class="banner" style="background-image:url('<?php echo thumb($category['parent']['thumb'], 0, 400);?>')">
    </div>
<?php elseif($default_banner): ?>
    <div class="banner" style="background-image:url('<?php echo thumb($default_banner[$rand]['path'], 0, 400);?>')">
    </div><?php endif; ?>
    <div class="container inner-container">
        <?php
 $bread = D('Category')->getParents($category['id']); $bread = array_reverse($bread); if($info['parent_id']) { $bread[] = array('title'=>$info['parent']['title'], 'link'=>$info['parent']['link']); } if($info) { $bread[] = array('title'=>'正文'); } $br_count = count($bread); ?>

<ul class="breadcrumb">
    <li><a href="/"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
    <?php if(is_array($bread)): foreach($bread as $k=>$one): if($k == $br_count-1): ?><li class="active"><?php echo ($one['title']); ?></li>
        <?php else: ?>
            <li><a href="<?php echo ($one['link']); ?>"><?php echo ($one['title']); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
        <?php  $children_id = D("Category")->getChildrenId(236); ?>
        <form action="" method="get" name="kind" onsubmit="return check_sub()" class="form-horizontal" role="form">
            <select onchange="window.location=this.value;" class="form-control input-sm">
                <option value="/category/236">- 类型 -</option>
                <?php if(is_array($children_id)): foreach($children_id as $key=>$one): $cat = D("Category")->getCategoryById($one);?>
                    <option value ="/category/<?php echo ($one); ?>" <?php if($category['id'] == $one): ?>selected<?php endif; ?>><?php echo ($cat['title']); ?></option><?php endforeach; endif; ?>
            </select>
            <input type="text" class="form-control input-sm" id="key_words" name="key_words" placeholder="关键字" value="<?php echo ($key_words); ?>">
            <input type="submit" class="btn btn-primary btn-sm" value="查询">
        </form>
        <div class="content row">
            <?php if(!$key_words): if( $category['id'] ) { $child=D('Category')->getChildrenId($category['id'],true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if($_GET['stid'])$filter['tag_id']=$_GET['stid'];if(true)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(true)list($pagesize, $page_num, $pagestring) = pagestring($count, 9);if(true)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 9,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i;?><div class="block">
                        <div class="thumb">
                            <a href="<?php echo ($page['link']); ?>"><img src="<?php echo thumb($page['thumb'], 180, 0);?>"></a>
                        </div>
                        <div class="details">
                            <div class="title">
                                【<a href="/category/<?php echo ($page['category_id']); ?>"><?php echo ($page['category_name']); ?></a></span>】
                                <a href="<?php echo ($page['link']); ?>"><?php echo ($page['title']); ?></a>                                
                            </div>
                            <?php if($page['extend']['found_time']): ?><p class="text-muted">
                                    <?php if($page['extend']['found_time']): ?><span>成立时间：</span>
                                        <span><?php echo ($page['extend']['found_time']); ?></span><?php endif; ?>
                                </p><?php endif; ?>
                            <div class="brief">
                                <?php echo trim($page['summary']?get_short($page['summary'], 300):get_short(trim(strip_tags($page['content'])),300));?>
                            </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
                <?php  ?>
                <?php if( $category['id'] ) { $child=D('Category')->getChildrenId($category['id'],true); }else { $child=D('Category')->getField('id',true); };if(false)$filter['weight']=false;if($_GET['stid'])$filter['tag_id']=$_GET['stid'];if(false)$count = D('Content')->getPagesByTypeId($child, 0, 0,$filter, true);if(false)list($pagesize, $page_num, $pagestring) = pagestring($count, 10);if(false)$pages = D('Content')->getPagesByTypeId($child, $page_num, $pagesize,$filter,false,false,true);else $pages = D('Content')->getPagesByTypeId($child, 1, 10,$filter,false,false,true,false);if(false)var_dump($pages); if(is_array($pages)): $i = 0; $__LIST__ = $pages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i; if(strpos($page['title'], $key_words) !== false): ?><div class="block">
                            <div class="thumb">
                                <img src="<?php echo thumb($page['thumb'], 160, 160);?>">
                            </div>
                            <div class="details">
                                <div class="title">
                                    <a href="<?php echo ($page['link']); ?>"><?php echo ($page['title']); ?></a>
                                </div>
                                <div class="found_time">
                                    <span>成立时间：</span><span><?php echo ($page['extend']['found_time']?$page['extend']['found_time']:"未知"); ?></span>
                                </div>
                                <div class="brief">
                                    <?php echo get_short(trim(strip_tags($page['content'])), 400);?>
                                </div>
                            </div>
                        </div><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
        </div>
        <div class="pagestring"><?php echo ($pagestring); ?></div>
        <div class="clearfix"></div>
    </div>
</div>
<script>
function check_sub() {
    if($("#key_words").val()=="") {
        $("#key_words").focus();
        return false;
    }
}
</script>
<link rel="stylesheet" type="text/css" href="/Application/Home/View/lingshan/styles/css/lrtk.css" />
<div id="code"></div>
<a href="http://weibo.com/lingshanfoundation" target="_blank">
  <div id="code_weibo"></div>
</a>
<div id="code_img"></div>
<a id="gotop" href="javascript:void(0)"></a>
<script type="text/javascript">
  function b(){
      h = $(window).height();
      t = $(document).scrollTop();
      if(t > h){
          $('#gotop').show();
      }else{
          $('#gotop').hide();
      }
  }
  $(document).ready(function(e) {
      b();
      $('#gotop').click(function(){
          $(document).scrollTop(0);   
      })
      $('#code').hover(function(){
              $(this).attr('id','code_hover');
              $('#code_img').show();
          },function(){
              $(this).attr('id','code');
              $('#code_img').hide();
      })
      
  });

  $(window).scroll(function(e){
      b();        
  });
</script>

<div id="footer">
    <div class="container">
        <div class="logo">
            <img src="/Application/Home/View/lingshan/styles/css/images/logo-w.png" />
        </div>
        <div class="friend-link">
            <p>友情链接：<a target="_blank" href="http://www.chinalingshan.com/index.aspx">灵山胜境</a></p>
        </div>
        <div class="copyright">
            <p>Copyright © <?php echo C('site_copyright');?> <?php echo C('site_link');?> All Rights Reserved</p>
        </div>
    </div>
</div>
<?php echo D('Config')->getConfigValue('analytics');?>
<body>
</html>