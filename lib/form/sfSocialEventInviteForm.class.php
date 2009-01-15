<?php

/**
 * sfSocialEventInvite form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialEventInviteForm extends BasesfSocialEventInviteForm
{

  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at'], $this['replied']);

    // make user_from hidden
    $uid = sfContext::getInstance()->getUser()->getAttribute('user_id', 0, 'sfGuardSecurityUser');
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $uid);
    $this->setValidator('user_from', new sfValidatorChoice(array('choices' => array($uid))));

    // make event_id hidden
    $eid = sfContext::getInstance()->get('Event')->getId();
    $this->widgetSchema['event_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('event_id', $eid);
    $this->setValidator('event_id', new sfValidatorChoice(array('choices' => array($eid))));

  }

}
