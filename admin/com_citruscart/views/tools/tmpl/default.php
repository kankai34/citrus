<?php 
/*------------------------------------------------------------------------
# com_citruscart - citruscart
# ------------------------------------------------------------------------
# author    Citruscart Team - Citruscart http://www.citruscart.com
# copyright Copyright (C) 2014 - 2019 Citruscart.com All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://citruscart.com
# Technical Support:  Forum - http://citruscart.com/forum/index.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access'); ?>
<?php JHtml::_('script', 'media/citruscart/js/citruscart.js', false, false); ?>
<?php $state = $this->state; ?>
<?php $form = $this->form; ?>
<?php $items = $this->items; ?>
<?php $app = JFactory::getApplication(); ?>
<form action="<?php echo JRoute::_( $form['action'] )?>" method="post" name="adminForm" enctype="multipart/form-data">

	<?php echo CitruscartGrid::pagetooltip( $app->input->getString('view') ); ?>
	
 <table>
 <?php echo CitruscartGrid::searchform($state->filter,JText::_('COM_CITRUSCART_SEARCH'), JText::_('COM_CITRUSCART_RESET') ) ?>
	

	<table class="table table-striped table-bordered" style="clear: both;">
		<thead>
            <tr>
                <th style="width: 5px;">
                	<?php echo JText::_('COM_CITRUSCART_NUM'); ?>
                </th>
                <th style="width: 50px;">
                	<?php echo CitruscartGrid::sort( 'COM_CITRUSCART_ID', "tbl.id", $state->direction, $state->order ); ?>
                </th>                
                <th style="text-align: left;">
                	<?php echo CitruscartGrid::sort( 'COM_CITRUSCART_NAME', "tbl.name", $state->direction, $state->order ); ?>
                </th>
				<th>
				</th>
            </tr>
            <tr class="filterline">
                <th colspan="2">
                    <?php $attribs = array('class' => 'inputbox', 'size' => '1', 'onchange' => 'document.adminForm.submit();'); ?>
                   <div class="range">
                        <div class="rangeline">
                            <input type="text" placeholder="<?php echo JText::_('COM_CITRUSCART_FROM'); ?>" id="filter_id_from" name="filter_id_from" value="<?php echo $state->filter_id_from; ?>" size="5" class="input input-tiny" />
                        </div>
                        <div class="rangeline">
                            <input type="text" placeholder="<?php echo JText::_('COM_CITRUSCART_TO'); ?>" id="filter_id_to" name="filter_id_to" value="<?php echo $state->filter_id_to; ?>" size="5" class="input input-tiny" />
                        </div>
                    </div>
                </th>
                <th style="text-align: left;">
                    <input id="filter_name" name="filter_name" value="<?php echo $state->filter_name; ?>" size="25" placeholder="<?php echo JText::_('COM_CITRUSCART_NAME');?>"/>
                </th>
                <th>
                </th>
            </tr>
            <tr>
                <th colspan="20" style="font-weight: normal;">
                    <div style="float: right; padding: 5px;"><?php echo $this->pagination->getResultsCounter(); ?></div>
                    <div style="float: left;"><?php echo $this->pagination->getListFooter(); ?></div>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="20">
                    <div style="float: right; padding: 5px;"><?php echo $this->pagination->getResultsCounter(); ?></div>
                    <?php echo $this->pagination->getPagesLinks(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
		<?php $i=0; $k=0; ?>
        <?php foreach ($items as $item) : ?>
            <tr class='row<?php echo $k; ?>'>
				<td align="center">
					<?php echo $i + 1; ?>
				</td>
				<td style="text-align: center;">
					<a href="<?php echo $item->link; ?>" class="badge badge-warning">
						<?php echo $item->id; ?>
					</a>
				</td>	
				<td style="text-align: left;">
					<a href="<?php echo $item->link; ?>">
						<?php echo $item->name; ?>
					</a>
				</td>	
				<td style="text-align: center;">
					[
					<a href="<?php echo $item->link; ?>" class="badge badge-success">
						<?php echo JText::_('COM_CITRUSCART_LOAD_TOOL'); ?>
					</a>
					]
				</td>
			</tr>
			<?php $i=$i+1; $k = (1 - $k); ?>
			<?php endforeach; ?>
			
			<?php if (!count($items)) : ?>
			<tr>
				<td colspan="10" align="center">
					<?php echo JText::_('COM_CITRUSCART_NO_ITEMS_FOUND'); ?>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="20">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>

	<input type="hidden" name="order_change" value="0" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="boxchecked" value="" />
	<input type="hidden" name="filter_order" value="<?php echo $state->order; ?>" />
	<input type="hidden" name="filter_direction" value="<?php echo $state->direction; ?>" />
	
	<?php echo $this->form['validate']; ?>
</form>