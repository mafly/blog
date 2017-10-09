<?php
/** 
 * Hi Baidu主题for Typecho
 * @package Hi Baidu
 * @author Slimcheng
 * @version 1.0
 * @link http://slimcheng.com/
 * 
 */
 
$this->need('header.php');
?>
<div id="content">
	<?php while($this->next()): ?>
	<?php 
		if( @stripos( $this->content , "<embed" ) !== false ){
			$post_type = "video";
		}else if( @stripos( $this->content , "<img" ) !== false ){
			$post_type = "image";
		}else{
			$post_type = "text";
		}
	?>
			<div class="posts is_<?php echo $post_type;?>">
				<div class="postclass"></div>
				<div class="hentry"><h2><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>" ><?php $this->title() ?></a></h2>	
					<div class="date-container"><span class="date"><?php $this->date('Y-m-d H:i:33'); ?></span></div>
					<div class="postContent"><?php $this->content('......'); ?></div>
					<div class="postInfo">
						<div class="postTags"><?php $this->category(', '); ?> &#47; <?php $this->tags(', ', true, 'none'); ?></div>
						<div class="postNotes">
						<!--<?php echo UYan_Plugin::getCounts($this->permalink."#uyan_frame");?>-->
						<a href="<?php $this->permalink() ?>" rel="bookmark" title="<?php $this->title(); ?>">阅读全文.</a>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
	<?php endwhile; ?>
	<?php if( !$this->next() ): ?>
		<div id="posts">
			<div class="hentry notfound">
				<img width="520" height="320" src="<?php $this->options->themeUrl('images/notfound.gif'); ?>">
				<p style="font-size:24px; line-height:70px;">啊~哦~ ，毛毛都没有！！！</p>
				<p style="margin-bottom:30px">请检查您输入的网址是否正确，或者点击链接继续浏览空间</p>
			</div>
		</div>
	<?php endif; ?>
</div>

<div id="pagenavi"><?php $this->pageNav('&#60;','&#62;',9,'...'); ?></div>

<?php $this->need('footer.php'); ?>
