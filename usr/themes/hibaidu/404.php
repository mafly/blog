<?php $this->need('header.php'); ?>
<div id="content">
<div id="posts">
	<div class="hentry notfound">
		<img width="520" height="320" src="<?php $this->options->themeUrl('images/notfound.gif'); ?>">
		<p style="font-size:24px; line-height:70px;">啊~哦~ 您要查看的页面不存在或已删除！</p>
		<p style="margin-bottom:30px">请检查您输入的网址是否正确，或者点击链接继续浏览空间</p>
	</div>
</div>
</div>
<script type="text/javascript">
	var $body = document.getElementsByTagName('body')[0];
	$body.onclick = function(){
		window.location.href = '/';
	}
</script>
<?php $this->need('footer.php'); ?>
