<?php

/**
 * Base actions for the sfSocialPlugin sfSocialNotify module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialNotify
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
class BasesfSocialNotifyActions extends sfActions
{

  /**
   * get a received notify
   * @param sfRequest $request A request object
   */
  public function executeGet(sfWebRequest $request)
  {
    $notify = $this->getRoute()->getObject();
    $notify->setModel();
    $notify->read();
    // this is really ugly! Refactoring needed
    switch ($notify->getModelName())
    {
      case 'sfSocialMessage':
        return $this->redirect('sf_social_message_read', $notify->getModel());
      case 'sfSocialContactRequest':
        return $this->redirect('@sf_social_contact_requests');
      case 'sfSocialEventInvite':
        return $this->redirect('sf_social_event', $notify->getModel()->getEvent());
      case 'sfSocialGroupInvite':
        return $this->redirect('sf_social_group', $notify->getModel()->getGroup());
    }
  }
}
