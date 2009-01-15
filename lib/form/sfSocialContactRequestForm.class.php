<?php

/**
 * sfSocialContactRequest form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialContactRequestForm extends BasesfSocialContactRequestForm
{
  public function configure()
  {
	  // hide unuseful fields
    unset($this['created_at'], $this['updated_at'], $this['user_from'], $this['accepted']);
		
		$this->widgetSchema['message'] = new sfWidgetFormTextarea();
		
    // current user's id
    $uid = sfContext::getInstance()->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $uid);
    $this->setValidator('user_from', new sfValidatorChoice(array('choices' => array($uid))));
  }
}
