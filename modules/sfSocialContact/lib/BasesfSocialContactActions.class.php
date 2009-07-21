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
    $text = $request->getParameter('text');
    $excludeIds = $request->getParameter('exclude_ids');
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
    if ($request->isMethod('post'))
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
    $request = sfSocialContactRequestPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($request, 'request not found');
    $this->forwardUnless($request->checkUserTo($this->user), 'sfGuardAuth', 'secure');
    $request->accept();
    $this->getUser()->addContact($request->getsfGuardUserRelatedByUserFrom());
    $this->getUser()->setFlash('notice', 'Contact request accepted.');
    $this->redirect('@sf_social_contact_requests');
  }

  /**
   * Deny contact request
   * @param sfRequest $request A request object
   */
  public function executeDenyrequest(sfWebRequest $request)
  {
    $request = sfSocialContactRequestPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($request, 'request not found');
    $this->forwardUnless($request->checkUserTo($this->user), 'sfGuardAuth', 'secure');
    $request->refuse();
    $this->getUser()->setFlash('notice', 'Contact request refused.');
    $this->redirect('@sf_social_contact_requests');
  }

  /**
   * Cancel contact request
   * @param sfRequest $request A request object
   */
  public function executeCancelrequest(sfWebRequest $request)
  {
    $request = sfSocialContactRequestPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($request, 'request not found');
    $this->forwardUnless($request->checkUserFrom($this->user), 'sfGuardAuth', 'secure');
    $request->cancel();
    $this->getUser()->setFlash('notice', 'Contact request canceled.');
    $this->redirect('@sf_social_contact_sentrequests');
  }

  /**
   * Delete a contact
   * @param sfRequest $request A request object
   */
  public function executeDelete(sfWebRequest $request)
  {
    $contact = sfSocialContactPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($contact, 'contact not found');
    $this->forwardUnless($contact->checkUserFrom($this->user), 'sfGuardAuth', 'secure');
    $contact->delete();
    $this->getUser()->setFlash('notice', 'Contact removed.');
    $this->redirect('@sf_social_contact_list');
  }
}
