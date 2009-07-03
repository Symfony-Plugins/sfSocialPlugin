<?php

/**
 * sfSocialContactRequest form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Lionel Guichard <lionel.guichard@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialContactRequestForm extends BasesfSocialContactRequestForm
{
  public function configure()
  {
	  // hide unuseful fields
    unset($this['created_at'], $this['updated_at'], $this['user_from'], $this['accepted']);

    // make "message" a textarea
		$this->widgetSchema['message'] = new sfWidgetFormTextarea();

    // current user's id
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $this->options['user']->getId());
    $this->setValidator('user_from', new sfValidatorChoice(array('choices' => array($this->options['user']->getId()))));
  }
}
