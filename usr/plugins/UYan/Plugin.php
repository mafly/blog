<?php
/**
 * 社会化评论插件-友言
 * 
 * @package UYan
 * @author Mr.Asong
 * @version 1.0.0
 * @date 2012-10-26
 * @link http://mrasong.com
 *
 *
 */
class UYan_Plugin implements Typecho_Plugin_Interface
{
	const ___MENU_ID = 1;
	const ___NAME = 'UYan';
	const ___TITLE = '管理留言(友言)';
	const ___SUBTITLE = '管理留言(友言)';
	const ___MANAGE = 'UYan/manage.php';

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		Helper::addPanel(self::___MENU_ID, self::___MANAGE, self::___TITLE, self::___SUBTITLE, 'administrator');
		Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'render');
		return self::___NAME . '插件启用成功，正在跳转至设置页面。<script type="text/javascript">setTimeout(function(){location.href="'. Typecho_Common::url("options-plugin.php?config=UYan", Helper::options()->adminUrl) .'";},2000);</script>';
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){ 
		Helper::removePanel(self::___MENU_ID, self::___MANAGE);
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
		$uyan_tip1 = new Typecho_Widget_Helper_Layout();
		$uyan_tip1->html('参数配置：');
		$form->addItem($uyan_tip1);	
		
		$uyan_uid =  new Typecho_Widget_Helper_Form_Element_Text('_uid', NULL, NULL, '友言ID号（数字）', 
			'如果您还没有注册友言，那就赶快 <a href="http://uyan.cc/register/" target="_blank">免费注册</a> 试一下吧。' );
		$form->addInput($uyan_uid);	
		
		$uyan_domain =  new Typecho_Widget_Helper_Form_Element_Text('_domain', NULL, ltrim($_SERVER['HTTP_HOST'], 'www.'), 
			'自定义指定域名', 
			'定义指定域名，合并两个域名下的评论，如果用户访问域名包括www.xxx.com或xxx.com，<br/>定义后
                 即可合并两个域名的评论，没有定义默认获取当前网页域名评论。' );
		$form->addInput($uyan_domain);
		
		$uyan_tip2 = new Typecho_Widget_Helper_Layout();
		$uyan_tip2->html('调用方法：在相应显示的地方，插入代码即可。');
		$form->addItem($uyan_tip2);	
		
		$uyan_tips =  new Typecho_Widget_Helper_Layout('ul', array('class'=>'typecho-option'));
		$uyan_tips->html('
		<li><label class="typecho-label">评论页面：</label> <span class="notice"> &lt;?php echo '. __CLASS__ .'::getComments($this); ?&gt; </span>
			<p class="description">打开 <b>commonts.php</b> 文件，将原文件清空，改为上面代码即可。</p></li>
		<li><label class="typecho-label">文章计数：</label> <span class="notice"> &lt;?php echo '. __CLASS__ .'::getCounts($this->permalink."#uyan_frame"); ?&gt; </span>
			<p class="description">参数为文章的链接地址，可以加入 #uyan_frame 锚点。</p></li>
		<li><label class="typecho-label">最新评论：</label> <span class="notice"> &lt;?php echo '. __CLASS__ .'::getNewComments(); ?&gt; </span></li>
		<li><label class="typecho-label">评论热榜：</label> <span class="notice"> &lt;?php echo '. __CLASS__ .'::getHotComments(); ?&gt; </span></li>
		<li><label class="typecho-label">最新文章：</label> <span class="notice"> &lt;?php echo '. __CLASS__ .'::getNewPosts(); ?&gt; </span></li>
		<li><label class="typecho-label">文章热榜：</label> <span class="notice"> &lt;?php echo '. __CLASS__ .'::getHotPosts(); ?&gt; </span></li>
		');	
		$form->addItem($uyan_tips);			
			
		$uyan_tip3 = new Typecho_Widget_Helper_Layout();
		$uyan_tip3->html('<h2>注意：添加上面代码的时候，请在外部加入插件是否开启的判断，防止出错。</h2>
		<div class="message notice">
		&nbsp;&nbsp;&nbsp;&nbsp;	&lt;?php if (isset($this->options->plugins["activated"]["'.self::___NAME.'"])) : ?&gt; <br/>
		&nbsp;&nbsp;&nbsp;&nbsp;		##评论相关代码## <br/>
		&nbsp;&nbsp;&nbsp;&nbsp;	&lt;?php endif;?&gt; 
		</div>');
		$form->addItem($uyan_tip3);	
	}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
	/**
	 * 获取插件配置
	 */
	public static function getConfig(){
		return Typecho_Widget::widget('Widget_Options')->plugin(self::___NAME);
	}
	
	/**
	 * 生成 script
	 * @parma 'list' => 评论列表js， 'plugin' => 小插件js
	 */	
	public static function getScript($type = 'list'){
		$config = self::getConfig();
		if( $type == 'list' ){
			return '<script type="text/javascript" id="UYScript" src="http://v1.uyan.cc/js/iframe.js?UYUserId='. $config->_uid .'" async=""></script>';		
		}
		return '<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid='. $config->_uid .'"></script>';	
	}
	
	/**
	 * 管理页面
	 */
	public static function getManage($type){
		$config = self::getConfig();
		$htmls = "
		<div id='uyan_frame'></div>
		<script type='text/javascript'>
		var uyan_config = {'du':'{$config->_uid}.control.uyan.cc', 'su':'control-{$config->_domain}', 'ct':'{$type}', 'md':'{$config->_domain}', 'uid':'{$config->_uid}'};
		</script>" . PHP_EOL . self::getScript();
		return $htmls;
	}
	
	/**
	 * 获取评论类型url
	 */
	public static function getTypeUrl($type = ''){
		return Typecho_Common::url('extending.php?panel=' . urlencode(trim(self::___MANAGE, '/')) . $type, Helper::options()->adminUrl);
	}
	
	/**
	 * 文章页面评论列表
	 * @access public
	 * @return string
	 */
	public static function getComments($obj){
		$config = self::getConfig();
		$_domain = empty( $config->_domain ) ? '' : "'du':'" . $config->_domain . "',";
		$htmls = "
		<div id='uyan_frame'></div>
		<script type='text/javascript'>
		var uyan_config = {'title':'{$obj->title}', 'url':'{$obj->permalink}', {$_domain} 'su':'{$obj->cid}'};
		</script>";
		return $htmls;
	}
	
	/**
	 * 小插件：评论热榜
	 */
	public static function getHotComments(){
		return '<div id="uyan_hotcmt_unit"></div>';
	}
	
	/**
	 * 小插件：最新评论
	 */
	public static function getNewComments(){
		return '<div id="uyan_newcmt_unit"></div>';
	}
	
	/**
	 * 小插件：文章热榜
	 */
	public static function getHotPosts(){
		return '<div id="uyan_hotate_unit"></div>';
	}
	
	/**
	 * 小插件：最新文章
	 */
	public static function getNewPosts(){
		return '<div id="uyan_newate_unit"></div>';
	}
	
	/**
	 * 小插件：评论计数
	 */
	public static function getCounts($url){
		return '<a href="'.$url.'" id="uyan_count_unit">0条评论</a>';
	}
	
	
	/**
	 * 加载js
	 */
	public static function render(){
		echo self::getScript() . PHP_EOL;
		echo self::getScript('plugin');
	}
	
}
