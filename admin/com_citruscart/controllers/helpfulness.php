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

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

class CitruscartControllerHelpfulness extends CitruscartController
{
	/**
	 * constructor
	 */
	function __construct()
	{
		parent::__construct();

		$this->set('suffix', 'helpfulness');
	}

    function display($cachable=false, $urlparams = false)
    {
    }

    /**
     * Adding helpfulness of review
     *
     */
    function reviewHelpfulness( )
    {
    	$input = JFactory::getApplication()->input;
        $user_id = JFactory::getUser( )->id;
        $Itemid = $input->getInt( 'Itemid', 0);
        $id = $input->getInt( 'product_id', 0 );
        $url = JRoute::_( "index.php?option=com_citruscart&view=products&task=view&Itemid=" . $Itemid . "&id=" . $id, false );

        if ( $user_id )
        {
            $productcomment_id = $input->getInt( 'productcomment_id', 0 );
            Citruscart::load( 'CitruscartHelperProduct', 'helpers.product' );
            $producthelper = new CitruscartHelperProduct( );
            JTable::addIncludePath( JPATH_ADMINISTRATOR .DIRECTORY_SEPARATOR. 'components' .DIRECTORY_SEPARATOR. 'com_citruscart' .DIRECTORY_SEPARATOR. 'tables' );
            $productcomment = JTable::getInstance( 'productcomments', 'CitruscartTable' );
            $productcomment->load( $productcomment_id );

            $helpful_votes_total = $productcomment->helpful_votes_total;
            $helpful_votes_total = $helpful_votes_total + 1;
            $helpfulness = $input->getInt( 'helpfulness', '' );
            if ( $helpfulness == 1 )
            {
                $helpful_vote = $productcomment->helpful_votes;
                $helpful_vote_new = $helpful_vote + 1;
                $productcomment->helpful_votes = $helpful_vote_new;
            }
            $productcomment->helpful_votes_total = $helpful_votes_total;

            $report = $input->getInt( 'report', '' );
            if ( $report == 1 )
            {
                $productcomment->reported_count = 1;
            }

            $help = array( );
            $help['productcomment_id'] = $productcomment_id;
            $help['helpful'] = $helpfulness;
            $help['user_id'] = $user_id;
            $help['reported'] = $report;
            JTable::addIncludePath( JPATH_ADMINISTRATOR . '/components/com_citruscart/tables' );
            $reviewhelpfulness = JTable::getInstance( 'ProductCommentsHelpfulness', 'CitruscartTable' );
            $reviewhelpfulness->load( array(
                    'user_id' => $user_id, 'productcomment_id' => $productcomment_id
            ) );

            $application = JFactory::getApplication( );
            if ( $report == 1 && !empty( $reviewhelpfulness->productcommentshelpfulness_id ) && empty( $reviewhelpfulness->reported ) )
            {
                $reviewhelpfulness->reported = 1;
                $reviewhelpfulness->save( );

                $productcomment->save( );
                $application->enqueueMessage( JText::sprintf( "COM_CITRUSCART_THANKS_FOR_REPORTING_THIS_REVIEW" ) );
                $application->redirect( $url );
                return;
            }

            if ( $reviewhelpfulness->reported )
            {
                $application->enqueueMessage( JText::sprintf( "COM_CITRUSCART_YOU_ALREADY_REPORTED_THIS_REVIEW" ) );
                $application->redirect( $url );
            }

            $reviewhelpfulness->bind( $help );
            if ( !empty( $reviewhelpfulness->productcommentshelpfulness_id ) )
            {
                $application->enqueueMessage( JText::sprintf( "COM_CITRUSCART_YOU_HAVE_ALREADY_GIVEN_YOUR_FEEDBACK_ON_THIS_REVIEW" ) );
                $application->redirect( $url );
                return;
            }
            else
            {
                $reviewhelpfulness->save( );
                $productcomment->save( );
                $application->enqueueMessage( JText::sprintf( "COM_CITRUSCART_THANKS_FOR_YOUR_FEEDBACK_ON_THIS_COMMENT" ) );
                $application->redirect( $url );
                return;
            }
        }
        else
        {
            $redirect = "index.php?option=com_user&view=login&return=" . base64_encode( $url );
            $redirect = JRoute::_( $redirect, false );
            JFactory::getApplication( )->redirect( $redirect );
            return;
        }
    }
}

