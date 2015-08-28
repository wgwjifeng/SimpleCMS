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

    <div class="article margin-nav">
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
        <div class="row">
            <div class="col-lg-9 col-sm-12">
                <div class="content">
                    <div class="main-content">
                        <div class="info-head">
                            <?php echo ($info['title']); ?>
                        </div>
                        <div class="article-infos">
                            <div class="article-info">
                                <?php if($info['source_name']): ?><span>来源：<a href="<?php echo ($info['source_link']); ?>" target="_blank"><?php echo ($info['source_name']); ?></a></span><?php endif; ?>
                            </div>
                            <div class="article-info">
                                <?php if($info['author_name']): ?><span class="muted">编辑：<?php echo ($info['author_name']); ?></span><?php endif; ?>
                            </div>
                            <div class="article-info">
                                <span class="muted">时间：<?php echo substr($info['publish_time'],0,16);?></span>
                            </div>
                            <div class="article-info pull-right">
                                <?php if($info['tags']): ?><span><span class="glyphicon glyphicon-tag icon-tag" aria-hidden="true"></span>
                                        <?php if(is_array($info['tags'])): foreach($info['tags'] as $key=>$t): ?><a href="/category/<?php echo ($category['id']); ?>?stid=<?php echo ($t['tag_id']); ?>"><?php echo ($t['name']); ?></a><?php endforeach; endif; ?>
                                    </span><?php endif; ?>
                            </div>
                        </div>
                        <?php if($info['summary']): ?><div class="summary">
                                <blockquote>
                                    <?php echo nl2br($info['summary']);?>
                                </blockquote>
                            </div><?php endif; ?>
                        <div class="details">
                            <?php echo ($info['content']); ?>
                        </div>
                    </div>
                </div>
                <div class="share">
                    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
                    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                </div>
                <br>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="right-widget">
                    
<div class="donate-way widget">
	<div class="right-tab">
		<img src="/Application/Home/View/lingshan/styles/css/images/logo-icon.png" style="width: 30px;"> 信息公开
	</div>
	<?php  $total_all = 1.4571; $total_month = 8762; ?>

<div class="donate-summary-block">
    <table class="table table-noborder">
        <tr>
            <td class="l"><?php echo ($total_all); ?></td>
            <td class="r">
                <div class="sign">亿元</div>
                <div>上一年募资总额</div>
            </td>
        </tr>
        <tr>
            <td class="l"><?php echo ($total_month); ?></td>
            <td class="r">
                <div class="sign">元</div>
                <div>上一月募资总额</div>
            </td>
        </tr>
    </table>

    <div class="text-center">
        <a class="btn btn-danger" target="_blank" href="<?php echo C('custom_goto_donate_link');?>">
            <span class="glyphicon glyphicon-heart"></span> 
            我要捐赠
        </a>
    </div>
</div>

</div>

                    
<div class="donate-way widget" style="padding-bottom: 15px;">
	<div class="right-tab" style="margin-bottom: 10px;">最新捐赠</div>
	<?php  $latest_donates = array( array('name' => '周芸', 'amount' => '500.00  ', 'donate_time' => '2015-06-25', ), array('name' => '李永', 'amount' => '300.00', 'donate_time' => '2015-06-22' ), array('name' => '李永', 'amount' => '300.00', 'donate_time' => '2015-06-22' ), array('name' => '吴卉（放生款）', 'amount' => '500.00', 'donate_time' => '2015-06-22'), array('name' => '彭振', 'amount' => '1620.00', 'donate_time' => '2015-06-15' ), array('name' => '施佳豪', 'amount' => '50.00', 'donate_time' => '2015-06-13' ), array('name' => '彭振', 'amount' => '1620.00', 'donate_time' => '2015-06-15' ), array('name' => '施佳豪', 'amount' => '50.00', 'donate_time' => '2015-06-13' ), array('name' => '梁晶晶', 'amount' => '50.00', 'donate_time' => '2015-06-13' ), ); ?>


<div class="donate-latest-block">
    <div id="scrollup" class="scrollup">
        <table class="table table-noborder table-striped table-condensed">
            <?php if(is_array($latest_donates)): foreach($latest_donates as $key=>$one): ?><tr>
                    <td><?php echo ($one['name']); ?></td>
                    <td><?php echo moneyit($one['amount']);?></td>
                    <td><?php echo substr($one['donate_time'],0,10);?></td>
                </tr><?php endforeach; endif; ?>
        </table>
    </div>
    <div class="text-center">
        <a class="btn btn-primary" target="_blank" href="/category/donate_list">
            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
            查看更多
        </a>
    </div>    
</div>



<script type="text/javascript">


// JavaScript Document
$(document).ready(function(){
    scrollUpDown($('#scrollup table'));


    function scrollUpDown(obj) {
        var _height = obj.outerHeight();
        var _html = obj.html();
        obj.html(_html + _html);
        function scroll() {
            return setInterval(function() {
                if (parseFloat(obj.css('margin-top')) > -(_height)) {
                    obj.css({ 'margin-top': parseFloat(obj.css('margin-top')) - 1 });
                } else {
                    obj.css({ 'margin-top': 0 });
                }
            }, 60);
        }
        var _interval = scroll();
        obj.hover(function() {
            _interval = clearInterval(_interval);
        }, function() {
            _interval = scroll();
        });
    }
});

</script>
</div>

                    
<div class="right-ads widget">
	<!--
	<div class="right-tab">更多内容</div>
	-->
	<?php $right_ads = D('Banner')->getBannerByName('right_ads'); ?>
	<div class="details">
		<?php if(is_array($right_ads)): foreach($right_ads as $key=>$one): ?><div class="one">
				<a href="<?php echo ($one['link']); ?>" target="_blank">
					<img src="<?php echo thumb($one['path'], 250, 0);?>" alt="<?php echo ($one['title']); ?>">
				</a>
			</div><?php endforeach; endif; ?>
	</div>
</div>

                </div>
            </div>
        </div>
    </div>
</div>
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