<?php

/**
 * sfSocialMessage form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialMessageForm extends BasesfSocialMessageForm
{
  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at']);

    // hide user_id, binding it to current user's id
    $uid = sfContext::getInstance()->getUser()->getAttribute('user_id', '',
                                                             'sfGuardSecurityUser');
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $uid);
    $this->setValidator('user_from',
                        new sfValidatorChoice(array('choices' => array($uid))));

    // add recipients field
    $c = new Criteria;
    $c->add(sfSocialContactPeer::USER_FROM, $uid);
    $c->setLimit(50);
    $c->addAscendingOrderByColumn(sfGuardUserPeer::USERNAME);
    $this->widgetSchema['to'] = new sfWidgetFormPropelChoiceMany(array('model'       => 'sfSocialContact',
                                                                       'add_empty'   => false,
                                                                       'peer_method' => 'doSelectJoinsfGuardUserRelatedByUserTo',
                                                                       'criteria'    => $c,
                                                                       'key_method'  => 'getUserId',
                                                                       )
                                                                 );
    $this->setValidator('to',
                        new sfValidatorPropelChoiceMany(array('model'    => 'sfGuardUser',
                                                              'column'   => 'id',
                                                              'required' => true)));

  }
}
