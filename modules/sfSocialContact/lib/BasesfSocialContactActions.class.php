<?php

/**
 * Base actions for the sfSocialPlugin sfSocialContact module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialContact
 * @author      Lionel Guichard <lionel.guichard@gmail.com>
 */
class BasesfSocialContactActions extends sfActions
{

  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();
  }

  /**
   * List of contacts
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialContactPeer::getContacts($this->user, $page);
  }

  /**
   * Search contacts
   * @param sfRequest $request A request object
   */
  public function executeSearch(sfWebRequest $request)
  {
    $text = $request->getParameter('q');
    $excludeIds = explode(',', urldecode($request->getParameter('exclude_ids')));
    $this->contacts = sfSocialContactPeer::search($this->user, $text, $excludeIds);
  }

  /**
   * List of received contact requests
   * @param sfRequest $request A request object
   */
  public function executeRequests(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialContactRequestPeer::getReceivedRequests($this->user, $page);
  }

  /**
   * List of sent contact requests
   * @param sfRequest $request A request object
   */
  public function executeSentrequests(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialContactRequestPeer::getSentRequests($this->user, $page);
  }

  /**
   * Send contact request
   * @param sfRequest $request A request object
   */
  public function executeSendrequest(sfWebRequest $request)
  {
    // possible user already selected
    $to = $request->getParameter('to');
    $userTo = null;
    if (!empty($to))
    {
      $userTo = sfGuardUserPeer::retrieveByUsername($to);
      $this->forward404Unless($userTo, 'user not found');
    }
    $this->form = new sfSocialContactRequestForm(null, array('user' => $this->user, 'to' => $userTo));
    if ($request->isMethod(sfRequest::POST))
    {
      if ($this->form->bindAndSave($request->getParameter($this->form->getName())))
      {
        $this->dispatcher->notify(new sfEvent($this->form->getObject(), 'social.contact_request'));
        $this->getUser()->setFlash('notice', 'Contact request sent.');
        $this->redirect('@sf_social_contact_list');
      }
    }
  }

  /**
   * Accept contact request
   * @param sfRequest $request A request object
   */
  public function executeAcceptrequest(sfWebRequest $request)
  {
    $cRequest = $this->getRoute()->getObject();
    $this->forwardUnless($cRequest->checkUserTo($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $cRequest->accept();
    $this->getUser()->addContact($cRequest->getFrom());
    $this->getUser()->setFlash('notice', 'Contact request accepted.');
    $this->redirect('@sf_social_contact_requests');
  }

  /**
   * Deny contact request
   * @param sfRequest $request A request object
   */
  public function executeDenyrequest(sfWebRequest $request)
  {
    $cRequest = $this->getRoute()->getObject();
    $this->forwardUnless($cRequest->checkUserTo($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $cRequest->refuse();
    $this->getUser()->setFlash('notice', 'Contact request refused.');
    $this->redirect('@sf_social_contact_requests');
  }

  /**
   * Cancel contact request
   * @param sfRequest $request A request object
   */
  public function executeCancelrequest(sfWebRequest $request)
  {
    $cRequest = $this->getRoute()->getObject();
    $this->forwardUnless($cRequest->checkUserFrom($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    if ($cRequest->cancel())
    {
      $this->getUser()->setFlash('notice', 'Contact request canceled.');
    }
    $this->redirect('@sf_social_contact_sentrequests');
  }

  /**
   * Delete a contact
   * @param sfRequest $request A request object
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $contact = $this->getRoute()->getObject();
    $this->forwardUnless($contact->checkUserFrom($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $contact->delete();
    $this->getUser()->setFlash('notice', 'Contact removed.');
    $this->redirect('@sf_social_contact_list');
  }
}
