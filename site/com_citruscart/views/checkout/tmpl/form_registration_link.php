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

defined('_JEXEC') or die('Restricted access');?>
<?php $url = JRoute::_( "index.php?option=com_citruscart&view=checkout", false ); ?>


    <div id="returnUserLoginWrapper" >

        <div class='componentheading'>
            <h4><?php echo JText::_('COM_CITRUSCART_RETURNING_USERS'); ?></h4>
        </div>

        <!-- LOGIN FORM -->

        <?php if (JPluginHelper::isEnabled('authentication', 'openid')) :
                $lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
                $langScript =   'var JLanguage = {};'.
                                ' JLanguage.WHAT_IS_OPENID = \''.JText::_('COM_CITRUSCART_WHAT_IS_OPENID').'\';'.
                                ' JLanguage.LOGIN_WITH_OPENID = \''.JText::_('COM_CITRUSCART_LOGIN_WITH_OPENID').'\';'.
                                ' JLanguage.NORMAL_LOGIN = \''.JText::_('COM_CITRUSCART_NORMAL_LOGIN').'\';'.
                                ' var modlogin = 1;';
                $document = JFactory::getDocument();
                $document->addScriptDeclaration( $langScript );
                JHTML::_('script', 'openid.js');
        endif; ?>

      <?php $url = JRoute::_( "index.php?option=com_citruscart&view=checkout", false ); ?>



 <?php if(version_compare(JVERSION,'1.6.0','ge')) {     // Joomla! 1.6+ code here ?>


   <form class="form-horizontal well" action="<?php echo JRoute::_( 'index.php', true, Citruscart::getInstance()->get('usesecure', '0') ); ?>" method="post" name="login" id="form-login" >

	<div class="form-group">
    	<label class="control-label"><?php echo JText::_('COM_CITRUSCART_USERNAME'); ?><span class>*</span>
	     <input id="citruscart-username" type="text" name="username" class="inputbox" size="18" alt="username" />
	     </label>
  	</div>
  <div class="form-group">
    <label for="inputPassword3" class="control-label">
     	<?php echo JText::_('COM_CITRUSCART_PASSWORD'); ?>
     	<span>*</span>
    	 <input id="citruscart-password" type="password" name="password" class="inputbox" size="18" alt="password" />
    	 </label>
  </div>
	<div class="form-group">
		  <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
	       <label><?php echo JText::_('COM_CITRUSCART_REMEMBER_ME'); ?>
	          <span style="float: left">
	           <div class="checkbox">
	            <input id="citruscart-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
	            </div>
	          </span></label>
	    <?php endif; ?>
	 <input type="submit" class="btn btn-success" name="submit" class="btn" value="<?php echo JText::_('COM_CITRUSCART_LOGIN') ?>" />
	</div>

	 <ul>
        <li>
            <?php // TODO Can we do this in a lightbox or something? Why does the user have to leave? ?>
        	 <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
     	    	<?php echo JText::_('COM_CITRUSCART_FORGOT_YOUR_PASSWORD'); ?></a>
             </li>
              <li>
                           <?php // TODO Can we do this in a lightbox or something? Why does the user have to leave? ?>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                            <?php echo JText::_('COM_CITRUSCART_FORGOT_YOUR_USERNAME'); ?></a>
                        </li>
                    </ul>




    <input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo base64_encode( $url ); ?>" />
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>

<?php } else {     // Joomla! 1.5 code here ?>

  <form action="<?php echo JRoute::_( 'index.php', true, Citruscart::getInstance()->get('usesecure', '0') ); ?>" method="post" name="login" id="form-login" >

            <table>
            <tr>
                <td style="height: 40px;">
                    <?php echo JText::_('COM_CITRUSCART_USERNAME'); ?> <span class>*</span>
                </td>
                <td>
                    <input type="text" name="username" class="inputbox" size="18" alt="username" />
                </td>
            </tr>
            <tr>
                <td style="height: 40px;">
                    <?php echo JText::_('COM_CITRUSCART_PASSWORD'); ?><span>*</span>
                </td>
                <td>
                    <input type="password" name="passwd" class="inputbox" size="18" alt="password" />
                </td>
            </tr>
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <tr>
                <td>
                    <?php echo JText::_('COM_CITRUSCART_REMEMBER_ME'); ?>
                </td>
                <td>
                    <span style="float: left">
                        <input type="checkbox" name="remember" class="inputbox" value="yes"/>
                    </span>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>
                </td>
                <td style="text-align: right;">
                    <input type="submit" name="submit" class="btn" value="<?php echo JText::_('COM_CITRUSCART_LOGIN') ?>" />
                </td>
            </tr>
            <tr>
                <td style="height: 40px;">
                    <ul>
                        <li>
                            <?php // TODO Can we do this in a lightbox or something? Why does the user have to leave? ?>
                            <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
                            <?php echo JText::_('COM_CITRUSCART_FORGOT_YOUR_PASSWORD'); ?></a>
                        </li>
                        <li>
                            <?php // TODO Can we do this in a lightbox or something? Why does the user have to leave? ?>
                            <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind' ); ?>">
                            <?php echo JText::_('COM_CITRUSCART_FORGOT_YOUR_USERNAME'); ?></a>
                        </li>
                    </ul>
                </td>
                <td>
                </td>
            </tr>
            </table>

           <input type="hidden" name="option" value="com_user" />
			<input type="hidden" name="task" value="login" />
            <input type="hidden" name="return" value="<?php echo base64_encode( $url ); ?>" />
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
<?php } ?>
    </div>
