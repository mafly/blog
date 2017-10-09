<?php
include 'header.php';
include 'menu.php';
$config = Typecho_Widget::widget('Widget_Options')->plugin('UYan');
?>
<div class="main">
    <div class="body body-950">
        <?php include 'page-title.php'; ?>
        <div class="container typecho-page-main">

		<?php if( empty($config->_uid) ): ?>
			<div style="text-align:center; padding:20px;">
				UserID 为空！如果您是友言注册用户，并且您的网站已通过验证，点击 <a href="<?php $options->adminUrl("options-plugin.php?config=UYan");?>">这里</a> 进行设置。<br/><br/>
				如果您还没有注册友言，那就赶快 <a href="http://uyan.cc/register/" target="_blank" title="友言">免费注册</a> 试一下吧。
			</div>
			<p style="text-align:right;">Plugin by <a target="_blank" title="Mr.Asong" href="http://mrasong.com">Mr.Asong</a></p>
		<?php else: ?>
			<ul class="typecho-option-tabs">
				<li<?php if(!isset($request->ct) || 'all' == $request->get('ct')): ?> class="current"<?php endif; ?>>
					<a href="<?php echo UYan_Plugin::getTypeUrl(); ?>">所有评论</a></li>
				<li<?php if('normal' == $request->get('ct')): ?> class="current"<?php endif; ?>>
					<a href="<?php echo UYan_Plugin::getTypeUrl('&ct=normal'); ?>">正常评论</a></li>
				<li<?php if('verify' == $request->get('ct')): ?> class="current"<?php endif; ?>>
					<a href="<?php echo UYan_Plugin::getTypeUrl('&ct=verify'); ?>">等待审核</a></li>
				<li<?php if('rubbish' == $request->get('ct')): ?> class="current"<?php endif; ?>>
					<a href="<?php echo UYan_Plugin::getTypeUrl('&ct=rubbish'); ?>">垃圾评论</a></li>
				<li<?php if('delete' == $request->get('ct')): ?> class="current"<?php endif; ?>>
					<a href="<?php echo UYan_Plugin::getTypeUrl('&ct=delete'); ?>">已被删除</a></li>
					
				
				<li class="right"><a href="http://www.uyan.cc/sites" target="_blank">友言</a></li>
				<li class="right"><a href="<?php $options->adminUrl("options-plugin.php?config=UYan");?>">设置</a></li>
			</ul>
			<!-- UY BEGIN -->
			<?php echo UYan_Plugin::getManage( (!isset($request->ct)) ? 'all' : $request->get('ct') ); ?>
			<!-- UY END -->
		<?php endif; ?>
        </div>
    </div>
</div>
<?php
include 'copyright.php';
include 'common-js.php';
include 'footer.php';
?>
