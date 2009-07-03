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
    $user = $this->options['user'];
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $user->getId());
    $this->setValidator('user_from',
                        new sfValidatorChoice(array('choices' => array($user->getId()))));

    // add recipients field
    if (!empty($this->options['reply_to']))
    {
      $this->widgetSchema['to'] = new sfWidgetFormChoiceMany(array('choices' => $user->getContactsAndSender($this->options['reply_to']->getUserFrom())));
    }
    else
    {
      $this->widgetSchema['to'] = new sfWidgetFormChoiceMany(array('choices' => $user->getContacts()));
    }
    $this->setValidator('to',
                        new sfValidatorPropelChoiceMany(array('model'    => 'sfGuardUser',
                                                              'column'   => 'id',
                                                              'required' => true)));

    // if it's a reply message, set defaults
    if (!empty($this->options['reply_to']))
    {
      $this->setDefault('to', $this->options['reply_to']->getsfGuardUser()->getId());
      $this->setDefault('subject', $this->options['reply_to']->getReplySubject());
    }

  }

}
