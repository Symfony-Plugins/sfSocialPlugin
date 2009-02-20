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
  /**
   * List of contacts
   *
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
		//myUser::addContact();
    $page = $request->getParameter('page');
    $this->pager = sfSocialContactPeer::getContacts($this->getUser()->getGuardUser(), $page);
  }

  /**
   * Search contacts
   *
   * @param sfRequest $request A request object
   */
  public function executeSearch(sfWebRequest $request)
  {
    $text = $request->getParameter('text');
    $exclude_ids = $request->getParameter('exclude_ids');
    $this->contacts = sfSocialContactPeer::search($this->getUser()->getGuardUser(),
                                                  $text, $exclude_ids);
  }

  /**
   * List of request a contacts
   *
   * @param sfRequest $request A request object
   */
  public function executeRequests(sfWebRequest $request)
  {
    $page = $request->getParameter('page');
    $this->pager = sfSocialContactRequestPeer::getReceiveRequests($this->getUser()->getGuardUser(), $page);
  }

  /**
   * Send request
   *
   * @param sfRequest $request A request object
   */
  public function executeSendrequest(sfWebRequest $request)
  {
    $this->form = new sfSocialContactRequestForm();
    if ($request->isMethod('post'))
    {
      $this->form->bindAndSave($request->getParameter($this->form->getName()));
    }
  }

  /**
   * Accept request
   *
   * @param sfRequest $request A request object
   */
  public function executeAcceptrequest(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless($id, 'id not passed');
    $this->request = sfSocialContactRequestPeer::retrieveByPK($id);
    $this->forward404Unless($this->request, 'request not found');

    $this->forward404Unless($this->request->checkUserFrom($this->getUser()->getGuardUser()),
                            'unauthorized');

    $this->request->accepted();

    $this->getUser()->addContact($this->request->getsfGuardUserRelatedByUserFrom());

    $this->redirect('@sf_social_contact_list');
  }

  /**
   * Deny request
   *
   * @param sfRequest $request A request object
   */
  public function executeDenyrequest(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless($id, 'id not passed');
    $this->request = sfSocialContactRequestPeer::retrieveByPK($id);
    $this->forward404Unless($this->request, 'request not found');

    $this->forward404Unless($this->request->checkUserFrom($this->getUser()->getGuardUser()),
                            'unauthorized');

    $this->request->refused();

    $this->redirect('@sf_social_contact_list');
  }

  /**
   * Delete a contact
   *
   * @param sfRequest $request A request object
   */
  public function executeDelete(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless($id, 'id not passed');
    $this->contact = sfSocialContactPeer::retrieveByPK($id);
    $this->forward404Unless($this->contact, 'contact not found');
    $this->forward404Unless($this->contact->checkUserFrom($this->getUser()->getGuardUser()), 'unauthorized');

    $this->contact->delete();

    $this->redirect('@sf_social_contact_list');
  }
}
