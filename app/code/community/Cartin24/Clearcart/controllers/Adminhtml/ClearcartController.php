<?php

 /**
 * Cartin24
 * @package    Cartin24_Clearcart
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Cartin24_Clearcart_Adminhtml_ClearcartController extends Mage_Adminhtml_Controller_action
{
    protected function _initAction(){
        $this->loadLayout()
            ->_setActiveMenu('clearcart/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Carts'), Mage::helper('adminhtml')->__('Manage Carts'));
        return $this;
        
    }   
   
    public function indexAction() {
		
        $this->_initAction();    
        $this->renderLayout();
    }

	# clear cart of a specific customer

    public function clearAction(){
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
				$idval = $this->getRequest()->getParam('id');
				
				$quoteItems = Mage::getModel('checkout/cart')->getQuote()
													->getCollection()
													->addFieldToFilter('entity_id',$idval);		
				$quoteItems->walk("delete");							
				          
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Cart is successfully cleared.'));
                $this->_redirect('*/*/');
				} catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				}
        }
        $this->_redirect('*/*/');
    }
     

    # clearing all carts 
      
    public function clearallAction(){       
		try {
			$quoteCollection = Mage::getModel('sales/quote')
										->getCollection();					
			foreach ($quoteCollection as $item) {
				$item->delete();	
			}	
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Successfully cleared all cart items.'));							
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
       
        $this->_redirect('*/*/');
    }
    

   # clearing all guest cart items
 
    public function clearguestAction(){       
		try {
			$quoteCollection = Mage::getModel('sales/quote')
										->getCollection()
										->addFieldToFilter('customer_id', array('null' => true));							
			foreach ($quoteCollection as $item) {
				$item->delete();	
			}	
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("All guest cart items are successfully cleared."));							
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}       
        $this->_redirect('*/*/');
    }
    

    # clearing selected customer's cart 

    public function massDeleteAction(){
        $ids = $this->getRequest()->getParam('quoteId');
        if(!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Item(s)'));
        } else {
            try {
                foreach ($ids as $id) {
                    $banners = Mage::getModel('sales/quote')->getCollection()->addFieldToFilter('entity_id',$id);
                    $banners->walk("delete");
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) are successfully deleted', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }  
    
    # Permission Allowed
	
	protected function _isAllowed(){
		return true;
	}    
	
}
