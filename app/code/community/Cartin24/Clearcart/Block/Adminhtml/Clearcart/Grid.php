<?php
 
 /**
 * Cartin24
 * @package    Cartin24_Clearcart
 * @copyright  Copyright (c) 2015-2016 Cartin24. (http://www.cartin24.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Cartin24_Clearcart_Block_Adminhtml_Clearcart_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('clearcartGrid');
        $this->setDefaultSort('clearcart_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
       
        $collection = Mage::getModel('checkout/cart')->getQuote()
													->getCollection()
													->addFieldToFilter('items_count',array('gt' => 0))
													->addFieldToFilter('customer_id',array('gt' => 0));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('customer_firstname', array( 
        'header'	=>	Mage::helper('clearcart')->__('Name'), 
        'align'	=>	'left', 
        'width'	=>	'100px', 
        'index'	=>	'customer_firstname', 
        'renderer' => new Cartin24_Clearcart_Block_Adminhtml_Renderer_CustomerName(), 
        
        ));
         
        $this->addColumn('customer_email', array(
            'header'    => Mage::helper('clearcart')->__('Email'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'customer_email',
            
        )); 
        $this->addColumn('items_count', array(
            'header'    => Mage::helper('clearcart')->__('No of Cart Items'),
            'align'     => 'left',
            'width'     => '120px',
            'default'   => '--',
            'index'     => 'items_count',
           
        ));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('clearcart')->__('Date'),
            'align'     => 'left',
            'width'     => '120px',
            'default'   => '--',
            'sortable'  => true,
            'index'     => 'created_at',
            
        )); 
        $this->addColumn('Clear',
            array(
                'header'    => Mage::helper('clearcart')->__('Clear'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('clearcart')->__('Clear'),
                        'url'     => array(
                            'base'=>'*/*/clear',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
            ));
       
        return parent::_prepareColumns();
    }
    
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id'); 
        $this->getMassactionBlock()->setFormFieldName('quoteId'); 
        $this->getMassactionBlock()->addItem('clear', array(
             'label'    => Mage::helper('clearcart')->__('Clear'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('clearcart')->__('Are you sure, you want to clear the selected carts?')
        ));
        return $this;
    }
    
    public function getRowUrl($row)
    {
       return false;
    }
}
