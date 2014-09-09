<?php

/**
 * @version			$Id$
 * @package			CitrusCart
 * @subpackage		payment
 * @copyright		Marvelic Engine Co., Ltd. All rights reserved.
 * @license			GNU General Public License version 2 or later
 */

defined('_JEXEC') or die('Restricted access');

Citruscart::load( 'CitruscartPaymentPlugin', 'library.plugins.payment' );

class plgCitruscartPayment_paysbuy extends CitruscartPaymentPlugin
{
	/**
	 * @var $_element  string  Should always correspond with the plugin's filename, 
	 *                         forcing it to be unique 
	 */
    var $_element    = 'payment_paysbuy';
    
	function plgCitruscartPayment_paysbuy(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage( '', JPATH_ADMINISTRATOR );
	}

	/************************************
     * Note to 3pd: 
     * 
     * The methods between here
     * and the next comment block are 
     * yours to modify
     * 
     ************************************/

    /**
     * Prepares the payment form
     * and returns HTML Form to be displayed to the user
     * generally will have a message saying, 'confirm entries, then click complete order'
     * 
     * Submit button target for onsite payments & return URL for offsite payments should be:
     * index.php?option=com_tienda&view=checkout&task=confirmPayment&orderpayment_type=xxxxxx
     * where xxxxxxx = $_element = the plugin's filename 
     *  
     * @param $data     array       form post data
     * @return string   HTML to display
     */
    function _prePayment( $data )
    {
        // prepare the payment form
		
		$vars = new JObject();
		$vars->biz = $this->params->get('biz');
		$vars->inv = $data['orderpayment_id'];
        $vars->amt = $data['orderpayment_amount'];
		$vars->currency = $this->params->get('currency', '764');
		
		// set paysbuy checkout type
        $order = JTable::getInstance('Orders', 'CitruscartTable');
        $order->load( $data['order_id'] );
        $items = $order->getItems();

		$product = JTable::getInstance('Products', 'CitruscartTable');
		$desc = '';
		$i = 0;
        foreach ($items as $item)
        {
			if( $i > 0 )  $desc .= ', ';
            $desc .= $item->orderitem_name;
			$desc .= ' '.JText::_('Price').' '.CitruscartHelperBase::number( @$item->orderitem_price + @$item->orderitem_attributes_price, array( 'thousands' =>'', 'decimal'=> '.' ) );
			$desc .= ' '.JText::_('Quantity').' '.$item->orderitem_quantity;
            $product->load( array('product_id'=>$item->product_id) );
            if (!empty($product->product_model))
            {
                $desc .= ' | ('.JText::_('Model').': '.$product->product_model;
            }
            if (!empty($item->orderitem_sku))
            {
                $desc .= ' |'.JText::_('SKU').': '.$item->orderitem_sku.')';
            }
			$i++;
        }

		$vars->itm	= $desc;
		$vars->postURL = JURI::root()."index.php?option=com_citruscart&view=checkout&task=confirmPayment&orderpayment_type=".$this->_element;

		// Sandbox mode?
        if($this->params->get('sandbox', '0') == 1) {
        	$vars->url = "https://demo.paysbuy.com/paynow.aspx?psb=true";
			if($this->params->get('visa')) 
				$vars->url .='&c=true';
			if($this->params->get('amex')) 
				$vars->url .='&a=true';
		} else {
			$vars->url = "https://www.paysbuy.com/paynow.aspx?psb=true";
			if($this->params->get('visa')) 
				$vars->url .='&c=true';
			if($this->params->get('amex')) 
				$vars->url .='&a=true';
		}

		// Billing Address
		$vars->opt_name		= $data['orderinfo']->billing_first_name.' '.$data['orderinfo']->billing_last_name;
		$vars->opt_email	= $data['orderinfo']->user_email;
		$vars->opt_mobile	= $data['orderinfo']->billing_phone_1;
		$vars->opt_address	= $data['orderinfo']->billing_address_1;

		$html = $this->_getLayout('prepayment', $vars);
        return $html;
	}

	/**
     * Processes the payment form
     * and returns HTML to be displayed to the user
     * generally with a success/failed message
     *  
     * @param $data     array       form post data
     * @return string   HTML to display
     */
    function _postPayment( $data )
    {
		$values = JRequest::get('request');

		//Get vars
		$payment_status	 = substr($values["result"], 0, 2);
		$cartnumber = trim(substr($values["result"],2));
		$amount = $values['amt'];
		$psbRef = $values['apCode'];

		$vars = new JObject();

		$data['transaction_details'] = $this->_getFormattedTransactionDetails( $data );

		$data_temp = array_merge($values, $data);

		if($payment_status =='00') {

			$return = $this->_processSale($data_temp);
    	
    		if(empty($return)) {
				$vars->message = JText::_('PAYSBUY_MESSAGE_PAYMENT_ACCEPTED_FOR_VALIDATION');
			} else {
				$vars->message = $return;
			}

		} else {
			$return = $this->_processSale($data_temp);
			$vars->message = JText::_('TIENDA_PAYSBUY_MESSAGE_PAYMENT_SECURITY_ERROR');
		}

		// Process the payment
        $html = $this->_getLayout('message', $vars);
                
        return $html;
	}

	/**
     * Prepares variables for the payment form
     * 
     * @return unknown_type
     */
    function _renderForm( $data )
    {
        $user = JFactory::getUser();    
        $vars = new JObject();
        
        $html = $this->_getLayout('form', $vars);
        
        return $html;
    }

	 /**
     * Processes the form data 
     */
    function _processSale($data)
    {
		/*
         * validate the payment data
         */
        $errors = array();

		// load the orderpayment record and set some values
        JTable::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_citruscart'.DS.'tables' );
		$orderpayment = JTable::getInstance('OrderPayments', 'CitruscartTable');
		$cartnumber = trim(substr($data["result"],2));
		$payment_status	 = substr($values["result"], 0, 2);
        $orderpayment->load( $cartnumber );
		$orderpayment->transaction_details  = $data['transaction_details'];
        $orderpayment->transaction_id       = $data['apCode'];
        $orderpayment->transaction_status   = $payment_status;
		
		// check the stored amount against the payment amount
    	Citruscart::load( 'CitruscartHelperBase', 'helpers._base' );
        $stored_amount = CitruscartHelperBase::number( $orderpayment->get('orderpayment_amount'), array( 'thousands'=>'' ) );
        $respond_amount = CitruscartHelperBase::number( $data['total'], array( 'thousands'=>'' ) );

		if ($stored_amount != $respond_amount ) {
        	$errors[] = JText::_('PAYSBUY_MESSAGE_AMOUNT_INVALID');
        	$errors[] = $stored_amount . " != " . $respond_amount;
        }

		 // set the order's new status and update quantities if necessary
        Citruscart::load( 'CitruscartHelperOrder', 'helpers.order' );
        Citruscart::load( 'CitruscartHelperCarts', 'helpers.carts' );
        $order = JTable::getInstance('Orders', 'CitruscartTable');
        $order->load( $orderpayment->order_id );

		//if (count($errors)) {
		if( $orderpayment->transaction_id == '' ) {
			// if an error occurred 
			$order->order_state_id = $this->params->get('failed_order_state', '10'); // FAILED
		} else {

			$order->order_state_id = $this->params->get('payment_received_order_state', '17'); // PAYMENT RECEIVED            
			// do post payment actions
			$setOrderPaymentReceived = true;            
			// send email
			$send_email = true;

		} 

		 // save the order
        if (!$order->save()){
        	$errors[] = $order->getError();
        }

		// save the orderpayment
        if (!$orderpayment->save()){
        	$errors[] = $orderpayment->getError(); 
        }
        
        if (!empty($setOrderPaymentReceived)){
            $this->setOrderPaymentReceived( $orderpayment->order_id );
        }

		 if ($send_email){
            // send notice of new order
            Citruscart::load( "CitruscartHelperBase", 'helpers._base' );
            $helper = CitruscartHelperBase::getInstance('Email');
            $model = Citruscart::getClass("CitruscartModelOrders", "models.orders");
            $model->setId( $orderpayment->order_id );
            $order = $model->getItem();
            $helper->sendEmailNotices($order, 'new_order');
        }

        return count($errors) ? implode("\n", $errors) : '';
	}

	/**
     * Formatts the payment data for storing
     * 
     * @param array $data
     * @return string
     */
    function _getFormattedTransactionDetails( $data ){

        $separator = "\n";
        $formatted = array();

        foreach ($data as $key => $value) 
        {
            if ($key != 'view' && $key != 'layout') 
            {
                $formatted[] = $key . ' = ' . $value;
            }
        }
        
        return count($formatted) ? implode("\n", $formatted) : '';  
    }
}