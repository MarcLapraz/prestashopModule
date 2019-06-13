<?php
/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    Marc Lapraz
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/







if (!defined('_PS_VERSION_')) {
    exit;
}

class Smoke extends Module
{
   // protected $config_form = false;

    public function __construct()
    {
        $this->name = 'smoke';
        $this->version = '1.0.0';
		$this->author = 'MLA';
		$this->tab = 'administration';
        $this->secure_key = Tools::encrypt($this->name);
        $this->need_instance = 0;
		$this->controllers = array('milky');
        $this->bootstrap = true;     
        $this->displayName = $this->l('Smoke Milky Prestashop module');
        $this->description = $this->l('module Prestashop');

        parent::__construct();
        $this->confirmUninstall = $this->l('Etes-vous sûr de vouloir désinstaller le module ?');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }


    public function install()
    {
        return parent::install() && $this->_installTab() 
		&& $this->registerHook('displaybackOfficeHeader')
		&& $this->registerHook('displayProductPriceBlock');	
			
    }


     public function hookDisplayBackOfficeHeader()
    {     
		$this->context->controller->addJquery();
        $this->context->controller->addJS($this->_path.'views/js/milky.js');
    }


    public function uninstall()
    {
        return  parent::uninstall() && $this->_uninstallTab() ;
    }


	
    public function getCustomerById()  {
      
        $id_category = Tools::getValue('id_category');
        $nbpoints = Tools::getValue('nbpoints');
       
        $query = new DbQuery();
					
		$query->select ('DISTINCT(c.id_customer) as numero, c.firstname as nom, c.lastname as prenom, p.reponse as numerocarte, sum(t.points) as totalpoint,  l.name as stat, g.name as genre');	
        $query->from('customer', 'c');
        $query->innerjoin('gender_lang','g','c.id_gender = g.id_gender');		
		$query->innerjoin('creg_reponses','p','c.id_customer = p.id_customer');	
		
		$query->leftjoin('totloyalty','t','c.id_customer = t.id_customer');	
		$query->leftjoin('totloyalty_state','s','t.id_loyalty_state=s.id_loyalty_state ');
		$query->leftjoin('totloyalty_state_lang','l','l.id_loyalty_state = t.id_loyalty_state');
		
        $query->where('p.reponse = '.(int)$id_category);
		$query->where('g.id_lang = 1 ');
		$query->groupBy('g.id_lang');
		$query->groupBy('l.id_lang');
		$query->groupBy('l.id_loyalty_state');
		

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
        
        echo json_encode($result);
    }


	 public function getCumul()  {
      
        $id_category = Tools::getValue('id_category');
        $nbpoints = Tools::getValue('nbpoints');
       
        $query = new DbQuery();
					
		$query->select ('DISTINCT(c.id_customer) as numero, sum(t.points) as cumulpoints');	
        $query->from('customer', 'c');
        $query->innerjoin('gender_lang','g','c.id_gender = g.id_gender');		
		$query->innerjoin('creg_reponses','p','c.id_customer = p.id_customer');	
		
		$query->leftjoin('totloyalty','t','c.id_customer = t.id_customer');	
		$query->leftjoin('totloyalty_state','s','t.id_loyalty_state=s.id_loyalty_state ');
		$query->leftjoin('totloyalty_state_lang','l','l.id_loyalty_state = t.id_loyalty_state');
		
        $query->where('p.reponse = '.(int)$id_category);
		$query->where('g.id_lang = 1 ');
		$query->where('t.points > 0');
		
		$query->groupBy('g.id_lang');
		$query->groupBy('l.id_lang');
		$query->groupBy('l.id_loyalty_state');
		

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
        
        echo json_encode($result);
    }
	
	
	
	
	
	
	
	
	
	
	public function insertPointsToCustomer(){
	
		$dt = new DateTime();
		$now = $dt->format('Y-m-d H:i:s');
		$nbpoints = Tools::getValue('nbpoints');   
		$id_customer = Tools::getValue('id_customer');			
		$query1 = "INSERT INTO `prstshp_totloyalty`(`id_loyalty_state`, `id_customer`, `id_order`, `id_cart_rule`, `points`, `date_add`, `date_upd`) VALUES ('2','.$id_customer.','0','0', '$nbpoints','$now' ,'$now')";    
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->Execute($query1);		      
        return $result ; 
    }
			
			
	 protected function _installTab()
    {
        $tab = new Tab();
        $tab->class_name = 'AdminSmokeMilky';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName('DEFAULT');
        $tab->icon = 'settings_applications';
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $this->l('Smoke');
        }
        try {
            $tab->save();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }

      
        return true;
    }

  
  
  
    protected function _uninstallTab()
    {
        $idTab = (int)Tab::getIdFromClassName('AdminSmokeMilky');
        if ($idTab) {
            $tab = new Tab($idTab);
            try {
                $tab->delete();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
 
        return true;
    }
	 
	 
	 


    
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
			$this->context->controller->addJquery();
        }
    }

 
    //public function hookHeader()
    //{
		
//        $this->context->controller->addJS(array($this->_path.'/views/js/milky.js'));
 //       $this->context->controller->addCSS($this->_path.'/views/css/front.css');
  //  }

   
}
