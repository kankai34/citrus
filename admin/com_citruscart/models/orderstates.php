<?php
/*------------------------------------------------------------------------
# com_citruscart
# ------------------------------------------------------------------------
# author   Citruscart Team  - Citruscart http://www.citruscart.com
# copyright Copyright (C) 2014 Citruscart.com All Rights Reserved.
# license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://citruscart.com
# Technical Support:  Forum - http://citruscart.com/forum/index.html
-------------------------------------------------------------------------*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

Citruscart::load( 'CitruscartModelBase', 'models._base' );

class CitruscartModelOrderstates extends CitruscartModelBase 
{
    protected function _buildQueryWhere(&$query)
    {
       	$filter     = $this->getState('filter');
        $filter_id_from = $this->getState('filter_id_from');
        $filter_id_to   = $this->getState('filter_id_to');
        $filter_name    = $this->getState('filter_name');
       	$filter_code    = $this->getState('filter_code');
        
       	if ($filter) 
       	{
			$key	= $this->_db->q('%'.$this->_db->escape( trim( strtolower( $filter ) ) ).'%');
			$where = array();
			$where[] = 'LOWER(tbl.order_state_id) LIKE '.$key;
			$where[] = 'LOWER(tbl.order_state_name) LIKE '.$key;
			$where[] = 'LOWER(tbl.order_state_code) LIKE '.$key;
			$where[] = 'LOWER(tbl.order_state_description) LIKE '.$key;
			$query->where('('.implode(' OR ', $where).')');
       	}
        if (strlen($filter_id_from))
        {
            if (strlen($filter_id_to))
            {
                $query->where('tbl.order_state_id >= '.(int) $filter_id_from);
            }
                else
            {
                $query->where('tbl.order_state_id = '.(int) $filter_id_from);
            }
        }
        if (strlen($filter_id_to))
        {
            $query->where('tbl.order_state_id <= '.(int) $filter_id_to);
        }
        if ($filter_name) 
        {
            $key    = $this->_db->q('%'.$this->_db->escape( trim( strtolower( $filter_name ) ) ).'%');
            $where = array();
            $where[] = 'LOWER(tbl.order_state_name) LIKE '.$key;
            $query->where('('.implode(' OR ', $where).')');
        }
        if ($filter_code) 
        {
            $key    = $this->_db->q('%'.$this->_db->escape( trim( strtolower( $filter_code ) ) ).'%');
            $where = array();
            $where[] = 'LOWER(tbl.order_state_code) LIKE '.$key;
            $query->where('('.implode(' OR ', $where).')');
        }
    }
        	
	public function getList($refresh = false)
	{
		//$list = parent::getList(); 
		
		if (empty( $this->_list ))
		{
			$query = $this->getQuery(true);
				
			$this->_list = $this->_getList( (string) $query, $this->getState('limitstart'), $this->getState('limit') );
		}
		$list = $this->_list;		
		
		// If no item in the list, return an array()
        /*if( empty( $list ) ){
        	return array();
        }*/
		
		foreach($list as $item)
		{
			$item->link = 'index.php?option=com_citruscart&controller=orderstates&view=orderstates&task=edit&id='.$item->order_state_id;
		}
		return $list;
	}
}
