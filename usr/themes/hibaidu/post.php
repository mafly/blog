<?php $this->need('header.php'); ?>
<div id="content">
<div id="posts">
	<div class="hentry">
		<div class="hentry_con">
			<h2><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" ><?php $this->title() ?></a></h2>	
			<div class="date-container"><span class="date"><?php $this->date('Y-m-d H:i:33'); ?></span></div>
			<div class="postContent"><?php $this->content(); ?></div>
			<div class="postInfo">
				<div class="postTags"><?php $this->category(', '); ?> &#47; <?php $this->tags(', ', true, 'none'); ?></div>
				<div class="postNotes"><?php echo UYan_Plugin::getCounts($this->permalink."#uyan_frame");?></div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="page_slide">
			<?php $this->thePrev('<div class="slide-pre">%s</div>'); ?>
			<?php $this->theNext('<div class="slide-next">%s</div>'); ?>
		</div>
		<?php //$this->need('comments.php'); ?>
		<!-- PingLun.La Begin -->
		<!-- <div id="pinglunla_here"></div><a href="http://www.pinglunla.com/" id="logo-pinglunla">评论啦</a><script type="text/javascript" src="http://s2.pinglun.la/md/pinglun.la.js" charset="utf-8"></script> -->
		<!-- PingLun.La End -->
		<!-- UY BEGIN -->
		<div id="uyan_frame"></div>
		<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=1887946"></script>
		<!-- UY END -->	
	</div>
</div>
</div>
<?php $this->need('footer.php'); ?>