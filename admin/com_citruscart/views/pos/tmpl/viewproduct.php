<?php

/*------------------------------------------------------------------------
# com_citruscart
# ------------------------------------------------------------------------
# author   Citruscart Team  - Citruscart http://www.citruscart.com
# copyright Copyright (C) 2014 Citruscart.com All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://citruscart.com
# Technical Support:  Forum - http://citruscart.com/forum/index.html
# Fork of Tienda
# @license GNU/GPL  Based on Tienda by Dioscouri Design http://www.dioscouri.com.
-------------------------------------------------------------------------*/
/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
	JHtml::_('script', 'media/citruscart/js/citruscart.js', false, false);
	JHtml::_('stylesheet', 'media/citruscart/css/pos.css');
	$state = @$this->state;
	$row = @$this->product;
	Citruscart::load('CitruscartHelperProduct', 'helpers.product');
?>
<form action="index.php?option=com_citruscart&view=pos&tmpl=component" method="post" name="adminForm" enctype="multipart/form-data">

    <table class="table table-striped table-bordered">
    	<tr>
    		<td>
    			<?php echo CitruscartHelperProduct::getImage($row -> product_id, 'id', $row -> product_name, 'full', false, false, array('width' => 150));?>
    		</td>
    		<td>
    			<h3><?php echo $row->product_name; ?></h3>
                <p><?php echo $row->product_description_short; ?></p>
            </td>
            <td>
	           	<div id="product_buy">
          			<?php
          			$values = array('user_id' => JFactory::getSession()->get('user_id', '', 'citruscart_pos') );
          			echo CitruscartHelperProduct::getCartButton( $row->product_id, 'viewproduct_addtocart', $values );
          			?>
               	</div>
            </td>
        </tr>
    	<tr >
    		<td colspan="3">
    			<div style="text-align: left;">
    				<a href="index.php?option=com_citruscart&view=pos&task=addproducts&tmpl=component">
        				<?php echo JText::_('COM_CITRUSCART_RETURN_TO_SEARCH_RESULTS'); ?>
        			</a>
    			</div>
    		</td>
    	</tr>
    </table>
</form>