</div>
</div>
<div id="footer" class="clear">
	<div class="foot_con">
		<div class="foot_con_main">
			<div class="foot_con_main_wrap">
				<div class="cols">
					<h3>最新文章</h3>
					<ul>
					<?php $this->widget('Widget_Contents_Post_Recent')
						->parse('<li><a href="{permalink}" title="{title}">{title}</a></li>'); ?>
					</ul>
				</div>
				<div class="cols by_month">
					<h3>分类查看</h3>
					<ul>
					<?php $this->widget('Widget_Metas_Category_List')
						->parse('<li><a href="{permalink}" title="{name}">{name} <sup>({count})</sup></a></li>'); ?>
					<?php $this->widget('Widget_Metas_Tag_Cloud')->to($tags);
						while($tags->next()): ?>
					<li><a href="<?php $tags->permalink(); ?>" title="<?php $tags->name(); ?>" <?php if($this->is('tag', $tags->slug)): ?>class="current"<?php endif; ?>><?php $tags->name(); ?></a></li>
					<?php endwhile; ?>	
					</ul>
				</div>
				<div class="cols by_month">
					<h3>按月归档</h3>
					<ul>
						<?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y-m')
							->parse('<li><a href="{permalink}">{date}({count})</a></li>'); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
        <p>© 2016 <a title="Mafly（马勇发）" target="_blank" href="http://mayongfa.cn">Mafly（马勇发）.</a> All rights reserved.<br>
		Power by <a href="http://typecho.org/" target="_blank">Typecho&#41;&#41;&#41;</a> Theme By <a href="http://www.blogcheng.com/hi-baidu-theme-for-typecho.html" target="_blank">SlimCheng</a>
		</p>
	</div>
</div>
<?php $this->footer(); ?>
<span id="goTopBtn" onmouseover="this.style.backgroundPosition='-63px -1px'" onmouseout="this.style.backgroundPosition='-3px -1px'"></span>
</div>
<script type="text/javascript">
//标签通栏下拉收起

if(document.getElementById("box-taglist").offsetHeight > 50){
	document.getElementById("slide_btn").style.display = 'block';
}
else{
	document.getElementById("slide_btn").style.display = 'none';
}
	
function slide_click(){
	var height = document.getElementById("box-taglist").offsetHeight;
	if(document.getElementById("taglist").offsetHeight < height)
	{
		document.getElementById("slide_btn").className = "slide_btn_up";
		document.getElementById("taglist").style.height = height+"px";
	}
	else
	{
		document.getElementById("slide_btn").className = "slide_btn_down";
		document.getElementById("taglist").style.height = "36px";
	}
}

//返回顶部
var BackTop=function(btnId){
	var btn=document.getElementById(btnId);
	var d=document.documentElement;	
	window.onscroll=set;
	btn.onclick=function (){
		btn.style.display="none";
		window.onscroll=null;
		this.timer=setInterval(function(){
			if(isSafari=navigator.userAgent.indexOf("Safari")>0){
				document.body.scrollTop-=Math.ceil(document.body.scrollTop*0.1);
				if(document.body.scrollTop==0) {clearInterval(btn.timer,window.onscroll=set);}
			}
			else{
				d.scrollTop-=Math.ceil(d.scrollTop*0.1);
				if(d.scrollTop==0) {clearInterval(btn.timer,window.onscroll=set);}
			}
			
		},10);
	};
	function set(){
		btn.style.display=d.scrollTop+document.body.scrollTop?"block":"none";
	}
}; 
	BackTop("goTopBtn");
</script>
</body>
</html>