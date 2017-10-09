<?php

function themeConfig($form) {
    $userAvatar = new Typecho_Widget_Helper_Form_Element_Text('userAvatar', NULL, NULL, _t('头像地址'), _t('在这里填入头像图片的URL地址'));
    $form->addInput($userAvatar);
	
    $userName = new Typecho_Widget_Helper_Form_Element_Text('userName', NULL, _t('博主姓名'), _t('博主姓名'), _t('在这里填写博主名称'));
    $form->addInput($userName);
	
    $userDesc = new Typecho_Widget_Helper_Form_Element_Textarea('userDesc', NULL, _t('在这里填写博主简介、个人信息'), _t('博主简介'), _t('在这里填写博主简介、个人信息'));
    $form->addInput($userDesc);

}
