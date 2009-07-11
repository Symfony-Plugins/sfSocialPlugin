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

    // exclude contacts from user_to
    $c = new Criteria;
    $c->add(sfSocialContactPeer::USER_FROM, $this->options['user']->getId(), Criteria::NOT_EQUAL)->
      setLimit(50)->
      addAscendingOrderByColumn(sfGuardUserPeer::USERNAME);
    $this->widgetSchema['user_to']->setOption('criteria', $c);
    $this->widgetSchema['user_to']->setOption('add_empty', true);
    $this->widgetSchema['user_to']->setLabel('To');

    // possible selected user
    if (!empty($this->options['to']))
    {
      $this->setDefault('user_to', $this->options['to']->getId());
    }

    // request can't be sent to a contact
    $this->widgetSchema['user_from']->setLabel('Error');  // trick!
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(
        array(
          new sfValidatorPropelUnique(array('model' => 'sfSocialContactRequest',
                                            'column' => array('user_from', 'user_to')),
                                      array('invalid'=> 'Request already sent.')),
          new sfValidatorPropelUnique(array('model' => 'sfSocialContact',
                                            'column' => array('user_from', 'user_to')),
                                      array('invalid'=> 'User is already a contact.'))
    )));

  }
}
