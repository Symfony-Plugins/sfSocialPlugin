<?php

/**
 * sfSocialMessage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialMessageForm extends BasesfSocialMessageForm
{
  public function configure()
  {
    $uid = sfContext::getInstance()->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');

    unset($this['created_at']);
    unset($this['read']);
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $uid);
    $this->setValidator('user_from', new sfValidatorChoice(array('choices' => array($uid))));
    $this->setValidator('subject', new sfValidatorString(array('required' => true)));
    $this->setValidator('text', new sfValidatorString(array('required' => true)));
  }
}
