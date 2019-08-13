<?php

 /**
 * Cartin24
 * @package    Cartin24_Clearcart
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Cartin24_Clearcart_Block_Adminhtml_Clearcart extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
	$this->_controller = 'adminhtml_clearcart';
	$this->_blockGroup = 'clearcart';
	$this->_headerText = Mage::helper('clearcart')->__('Manage Carts');	
	
	$this->_addButton('clearcar_guest', array(
       'label' => $this->__('Clear All Guest Carts'),
       'onclick' => "setLocation('".$this->getUrl('*/*/clearguest')."')",
    ));		
	
	$this->_addButton('clearcart_controller', array(
       'label' => $this->__('Clear All Carts'),
       'onclick' => "setLocation('".$this->getUrl('*/*/clearall')."')",
    ));
   
	parent::__construct();
	$this->_removeButton('add');
  } 
}
