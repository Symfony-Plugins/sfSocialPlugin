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
    $this->widgetSchema['to'] = new sfWidgetFormChoiceMany(array('choices' => $this->getRcpts()));
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

    // possible recipient passed via parameter
    if (!empty($this->options['to']))
    {
      $this->setDefault('to', $this->options['to']->getId());
    }

  }

  /**
   * return recipients as an array
   * @return array
   */
  private function getRcpts()
  {
    // in a reply, we need to be sure that sender is in recipients' list
    if (!empty($this->options['reply_to']))
    {
      $contacts = $this->options['user']->getContactsAndSender($this->options['reply_to']->getUserFrom());
    }
    // same if a recipient was passed
    elseif (!empty($this->options['to']))
    {
      $contacts = $this->options['user']->getContactsAndSender($this->options['to']->getId());
    }
    else
    {
      $contacts = $this->options['user']->getContacts();
    }
    if (empty($contacts))
    {
      return array();
    }
    foreach ($contacts as $contact)
    {
      $return[$contact->getId()]  = $contact->getUsername();
    }
    return $return;

  }

}
