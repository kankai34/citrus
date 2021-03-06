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
 ?>
<?php //JHtml::_('script', 'citruscart.js', 'media/citruscart/js/');
$doc = JFactory::getDocument();
$doc->addScript(JUri::root().'media/citruscart/js/citruscart.js');
?>
<?php $form = $this->form; ?>
<?php

/* Get the application */
$app = JFactory::getApplication();

$sender_name    = $app->input->getString('sender_name');
$sender_mail    = $app->input->getString('sender_mail');
$sender_message = $app->input->getString('sender_message');



?>
<?php $success = $app->input->getInt('success', 0);?>
<?php if($success && Citruscart::getInstance()->get('ask_question_modal', '1')):?>

<script type="text/javascript">
onload=setTimeout("window.parent.document.getElementById( 'sbox-window' ).close()", 2000);
</script>
<?php endif;?>

<div class="citruscart_askquestion" style="padding: 20px;">
<form id="adminForm" action="<?php echo JRoute::_('index.php') ?>" method="post" class="adminForm" name="adminForm" enctype="multipart/form-data" >
	<label for="sender_name"><?php echo JText::_('COM_CITRUSCART_NAME');?></label>
	<br><input type="text" value="<?php echo $sender_name;?>" class="inputbox" size="30" id="sender_name" name="sender_name"><br><br>
	<label for="sender_mail"><?php echo JText::_('COM_CITRUSCART_E-MAIL_ADDRESS');?></label>
	<br><input type="text" value="<?php echo $sender_mail;?>" class="inputbox" label="Your email" size="30" name="sender_mail" id="sender_mail"><br><br>
	<label for="sender_message"><?php echo JText::_('COM_CITRUSCART_ENTER_YOUR_MESSAGE');?></label><br>
	<textarea class="inputbox" id="sender_message" name="sender_message" cols="60" rows="10"><?php echo $sender_message;?></textarea><br>
	<!-- CAPTCHA HERE -->
	<?php if (Citruscart::getInstance()->get('ask_question_showcaptcha', '1') == 1 ): ?>
    <?php Citruscart::load( 'CitruscartRecaptcha', 'library.recaptcha' );?>
    <?php $recaptcha = new CitruscartRecaptcha(); ?>
    <?php $publickey = "6LcAcbwSAAAAAIEtIoDhP0cj7AAQMK9hqzJyAbeD"; ?>
    <div><?php echo $recaptcha->recaptcha_get_html($publickey); ?></div>
    <?php endif;?>
    <br>
    <input type="hidden" value="com_citruscart" name="option" />
    <input type="hidden" value="products" name="view" />
     <input type="button" onclick="citruscartSubmitForm('sendAskedQuestion');" value="<?php echo JText::_('COM_CITRUSCART_SEND'); ?>" />
    <input type="hidden" name="product_id" value="<?php echo $app->input->getInt('id');; ?>" />
    <input type="hidden" name="task" id="task" value="sendAskedQuestion" />
    <input type="hidden" name="return" id="return" value="<?php echo $app->input->getInt('return');?>" />
</form>
</div>

