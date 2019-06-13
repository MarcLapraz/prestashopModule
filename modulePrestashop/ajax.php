<?php 
require_once('../../config/config.inc.php');
require_once('../../init.php');
require_once ('smoke.php');


if(Tools::getIsset('token') && Tools::getIsset('action'))
{
	
	$action = Tools::getValue('action');
	
	if ($action == 'get_products'){
		$dp = new Smoke;
		$r =  $dp->getCustomerById();
		echo $r;
	}
	
	if ($action == 'insertpoints'){
		
		
		$dp = new Smoke;
		$r = $dp->insertPointsToCustomer();
		echo $r ; 
			
	}
	
	if($action == 'get_cumul'){
		
		
		$dp = new Smoke;
		$r = $dp->getCumul();
		echo $r ;
		
		
	}
	
	
	

	
}

 


