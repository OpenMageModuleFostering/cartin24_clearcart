<?php 

 /**
 * Cartin24
 * @package    Cartin24_Clearcart
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Cartin24_Clearcart_Block_Adminhtml_Renderer_CustomerName extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract 
{ 
	# Merge customer's first name and last name in a single admin grid field
	  
	public function render(Varien_Object $row) { 
		if ($row->getData('customer_firstname') != NULL || $row->getData('customer_lastname') != NULL){ 
		   
			$firstName 	= $row->getData('customer_firstname');
			$lastName 	= $row->getData('customer_lastname'); 
		   
			if ($lastName != NULL) { 
				return $firstName . ' ' . $lastName; 
			}else { 
				return $firstName;
			} 
		   
		} else {
			return Mage::helper('clearcart')->__('UNKNOWN USER');
		} 
							  
	} 
}
?>
