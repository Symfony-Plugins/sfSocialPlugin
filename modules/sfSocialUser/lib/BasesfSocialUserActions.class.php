<?php

/**
 * Base actions for the sfSocialPlugin sfSocialUser module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialUser
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
abstract class BasesfSocialUserActions extends sfActions
{

  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();
  }

  /**
   * User's page
   * @param sfRequest $request A request object
   */
  public function executeUser(sfWebRequest $request)
  {
    $this->pageUser = $this->getRoute()->getObject();
    try
    {
      $this->profile = $this->pageUser->getProfile();
    }
    catch (sfException $e)
    {
      throw new sfException('You must implement sfGuardUserProfile to use this module. Please refer to sfGuardPlugin documentation.');
    }
  }

  /**
   * profile edit
   * @param sfRequest $request A request object
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new sfSocialProfileForm($this->user);
    if ($request->isMethod(sfRequest::POST))
    {
      if ($this->form->bindAndSave($request->getParameter($this->form->getName()),
                                   $request->getFiles($this->form->getName())))
      {
        $this->form->save();
        $this->getUser()->setFlash('notice', 'Profile saved.');
        $this->redirect('sf_social_user', $this->user);
      }
    }
  }

  /**
   * User's contacts
   * @param sfRequest $request A request object
   */
  public function executeContacts(sfWebRequest $request)
  {
    $this->page = $request->getParameter('page', 1);
    $this->pageUser = $this->getRoute()->getObject();
    $this->pager = $this->pageUser->getContactsPager($this->page);
  }

  /**
   * Search for users
   * @param sfRequest $request A request object
   */
  public function executeSearch(sfWebRequest $request)
  {
    $this->page = $request->getParameter('page', 1);
    $this->name = $request->getParameter('name');
    $this->pager = sfSocialGuardUserPeer::search($this->name, $this->page);
  }

}
