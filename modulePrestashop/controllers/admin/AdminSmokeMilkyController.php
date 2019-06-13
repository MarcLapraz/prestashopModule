<?php
class AdminSmokeMilkyController extends ModuleAdminController {

	public function _construct(){
		parent::_construct();
	}

	public function init(){
		parent::init();
		$this->bootstrap = true ; 
	}

	public function initContent(){
		parent::initContent();
		$this->context->smarty->assign(array());
		$this->setTemplate('milky.tpl');
		$this->addJquery();
	}
}
