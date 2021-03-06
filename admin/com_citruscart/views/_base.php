<?php
/*------------------------------------------------------------------------
# com_citruscart - citruscart
# ------------------------------------------------------------------------
# author    Citruscart Team - Citruscart http://www.citruscart.com
# copyright Copyright (C) 2014 - 2019 Citruscart.com All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://citruscart.com
# Technical Support:  Forum - http://citruscart.com/forum/index.html
# Fork of Tienda
# @license GNU/GPL  Based on Tienda by Dioscouri Design http://www.dioscouri.com.
-------------------------------------------------------------------------*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.'/libraries/dioscouri/library/view/admin.php');

class CitruscartViewBase extends DSCViewAdmin
{
    function __construct( $config=array() )
    {
        parent::__construct( $config );

        $this->defines = Citruscart::getInstance();
    }

	/**
	 * Displays a layout file
	 *
	 * @param unknown_type $tpl
	 * @return unknown_type
	 */
	function display($tpl = null)
	{
		$doc = JFactory::getDocument();
		//including core JS because it needs to be included in modals and since we have so many including here keeps that from failing.
		JHTML::_('behavior.modal');
		JHtml::_('script', 'media/system/js/core.js', false, false);
		JHtml::_('script', 'media/citruscart/js/citruscart.js', false, false);

		//DSC::loadBootstrap();
		DSC::loadJQuery('latest', true, 'citruscartJQ');

		JHtml::_('stylesheet', 'media/citruscart/css/common.css');
		parent::display($tpl);

	}


	/**
	 * The default toolbar for a list
	 * @return unknown_type
	 */
	function _defaultToolbar()
	{
		JToolBarHelper::editList();
		JToolBarHelper::deleteList(JText::_('COM_CITRUSCART_VALID_DELETE_ITEMS'));
		JToolBarHelper::addnew();
	}

	/**
	 * The default toolbar for editing an item
	 * @param $isNew
	 * @return unknown_type
	 */
	function _formToolbar($isNew = null)
	{
		$divider = false;
		$surrounding = (!empty($this -> surrounding)) ? $this -> surrounding : array();
		if (!empty($surrounding['prev'])) {
			$divider = true;
			JToolBarHelper::custom('saveprev', "saveprev", "saveprev", 'COM_CITRUSCART_SAVE_PLUS_PREV', false);
		}
		if (!empty($surrounding['next'])) {
			$divider = true;
			JToolBarHelper::custom('savenext', "savenext", "savenext", 'COM_CITRUSCART_SAVE_PLUS_NEXT', false);
		}
		if ($divider) {
			JToolBarHelper::divider();
		}

		JToolBarHelper::custom('savenew', "savenew", "savenew", 'COM_CITRUSCART_SAVE_PLUS_NEW', false);
		JToolBarHelper::save('save');
		JToolBarHelper::apply('apply');

		if ($isNew) {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel('close', 'COM_CITRUSCART_CLOSE');
		}
	}

	/**
	 * The default toolbar for viewing an item
	 * @param $isNew
	 * @return unknown_type
	 */
	function _viewToolbar($isNew = null)
	{
		$divider = false;
		$surrounding = (!empty($this -> surrounding)) ? $this -> surrounding : array();
		if (!empty($surrounding['prev'])) {
			$divider = true;
			JToolBarHelper::custom('prev', "prev", "prev", JText::_('COM_CITRUSCART_PREV'), false);
		}
		if (!empty($surrounding['next'])) {
			$divider = true;
			JToolBarHelper::custom('next', "next", "next", JText::_('COM_CITRUSCART_NEXT'), false);
		}
		if ($divider) {
			JToolBarHelper::divider();
		}

		JToolBarHelper::cancel('close', JText::_('COM_CITRUSCART_CLOSE'));
	}

	public function renderSubmenu(){

		 	require_once(JPATH_ADMINISTRATOR.'/components/com_citruscart/helpers/toolbar.php');
			$toolbar = new CitruscartToolBar();
			Citruscart::load('CitruscartToolbar','helpers.toolbar.php');
			$toolbar->renderLinkbar();

	}

}
