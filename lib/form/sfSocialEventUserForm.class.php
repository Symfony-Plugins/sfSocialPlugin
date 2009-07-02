<?php

/**
 * sfSocialEventUser form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialEventUserForm extends BasesfSocialEventUserForm
{

  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at']);

    // make confirm a choice
    $this->widgetSchema['confirm'] = new sfWidgetFormChoice(array(
      'choices'  => sfSocialEventUser::$choices,
      'expanded' => true,
    ));

    // make user_id hidden
    $uid = sfContext::getInstance()->getUser()->getAttribute('user_id', 0, 'sfGuardSecurityUser');
    $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_id', $uid);
    $this->setValidator('user_id', new sfValidatorChoice(array('choices' => array($uid))));

    // make event_id hidden
    $eid = sfContext::getInstance()->get('Event')->getId();
    $this->widgetSchema['event_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('event_id', $eid);
    $this->setValidator('event_id', new sfValidatorChoice(array('choices' => array($eid))));
  }

}
