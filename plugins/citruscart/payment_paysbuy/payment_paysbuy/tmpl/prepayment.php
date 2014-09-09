<?php

/**
 * @version			$Id$
 * @package			CitrusCart
 * @subpackage		payment
 * @copyright		Marvelic Engine Co., Ltd. All rights reserved.
 * @license			GNU General Public License version 2 or later
 */

defined('_JEXEC') or die('Restricted access');
?>
<form action='<?php echo $vars->url; ?>' method='post'>
	<input type="hidden" name="psb" value="psb" />
	<input type="hidden" name="biz" value="<?php echo @$vars->biz; ?>" />
	<input type="hidden" name="inv" value="<?php echo @$vars->inv; ?>" />
	<input type="hidden" name="itm" value="<?php echo @$vars->itm; ?>" />
	<input type="hidden" name="amt" value="<?php echo @$vars->amt; ?>" />
	<input type="hidden" name="postURL" value="<?php echo @$vars->postURL; ?>" />
	<input type="hidden" name="opt_fix_redirect" value="1" />
	<input type="hidden" name="currencyCode" value="<?php echo $vars->currency; ?>">
	<input type="hidden" name="opt_name" value="<?php echo @$vars->opt_name; ?>" />
	<input type="hidden" name="opt_email" value="<?php echo @$var->opt_email; ?>" />
	<input type="hidden" name="opt_mobile" value="<?php echo @$var->opt_mobile; ?>" />
	<input type="hidden" name="opt_address" value="<?php echo @$var->opt_address; ?>" />
	<input type="hidden" name="opt_detail" value="<?php echo @$var->opt_detail?>" />
	<input type="image" src="https://www.PAYSBUY.com/images/p_click2pay.gif" border="0" name="submit" alt="Make payments with PAYSBUY - it's fast, free and secure!" />
</form>