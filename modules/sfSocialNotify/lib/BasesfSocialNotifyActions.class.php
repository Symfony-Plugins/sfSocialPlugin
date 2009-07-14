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
    $notify = sfSocialNotifyPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($notify, 'notify not found');
    $notify->setModel();
    $notify->read();
    // this is really ugly! Refactoring needed
    switch ($notify->getModelName())
    {
      case 'sfSocialMessage':
        return $this->redirect('@sf_social_message_read?id=' . $notify->getModelId());
      case 'sfSocialContactRequest':
        return $this->redirect('@sf_social_contact_requests');
      case 'sfSocialEventInvite':
        return $this->redirect('@sf_social_event?id=' . $notify->getModel()->getsfSocialEvent()->getId());
      case 'sfSocialGroupInvite':
        return $this->redirect('@sf_social_group?id=' . $notify->getModel()->getsfSocialGroup()->getId());
    }
  }
}
