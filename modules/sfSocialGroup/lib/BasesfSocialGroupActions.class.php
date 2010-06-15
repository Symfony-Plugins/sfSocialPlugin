<?php

/**
 * Base actions for the sfSocialPlugin sfSocialGroup module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialGroup
 * @author      Massimiliano Arione <garakkio@gmail.com>
 * @version     SVN: $Id: BaseActions.class.php 12628 2008-11-04 14:43:36Z Kris.Wallsmith $
 */
abstract class BasesfSocialGroupActions extends sfActions
{

  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();
  }

  /**
   * List of all groups
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialGroupPeer::getGroups($page);
  }

  /**
   * List of user's groups
   * @param sfRequest $request A request object
   */
  public function executeMylist(sfWebRequest $request)
  {
    $this->groups = $this->user->getGroups();
  }

  /**
   * View a a group
   * @param sfRequest $request A request object
   */
  public function executeView(sfWebRequest $request)
  {
    $this->group = $this->getRoute()->getObject();
    // invite form
    if ($this->group->isMember($this->user))
    {
      $this->form = new sfSocialGroupInviteForm(null, array('user' => $this->user,
                                                            'group' => $this->group));
    }
  }

  /**
   * Edit a group
   * @param sfRequest $request A request object
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->group = $this->getRoute()->getObject();
    $this->forwardUnless($this->group->isAdmin($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new sfSocialGroupForm($this->group, array('user' => $this->user));
    if ($request->isMethod(sfRequest::POST))
    {
      if ($this->form->bindAndSave($request->getParameter($this->form->getName())))
      {
        $this->getUser()->setFlash('notice', 'Group modified.');
        $this->redirect('sf_social_group', $this->form->getObject());
      }
    }
  }

  /**
   * Create a new group
   * @param sfRequest $request A request object
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new sfSocialGroupForm(null, array('user' => $this->user));
    if ($request->isMethod(sfRequest::POST))
    {
      if ($this->form->bindAndSave($request->getParameter($this->form->getName())))
      {
        $this->getUser()->setFlash('notice', 'Group created.');
        $this->redirect('@sf_social_group?id=' . $this->form->getObject()->getId());
      }
    }
  }

  /**
   * Invite another user to join group
   * @param sfRequest $request A request object
   */
  public function executeInvite(sfWebRequest $request)
  {
    $this->group = $this->getRoute()->getObject();
    $this->forwardUnless($this->group->isAdmin($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new sfSocialGroupInviteForm(null, array('user' => $this->user,
                                                          'group' => $this->group));
    if ($this->form->bindAndSave($request->getParameter($this->form->getName())))
    {
      $this->dispatcher->notify(new sfEvent($this->form->getObjects(), 'social.group_invite'));
      $this->getUser()->setFlash('notice', '%1% users invited.');
      $this->getUser()->setFlash('nr', count($this->form->getValue('user_id')));
    }
    $this->redirect('sf_social_group', $this->group);
  }

  /**
   * Join a group directly
   * @param sfRequest $request A request object
   */
  public function executeJoin(sfWebRequest $request)
  {
    $group = $this->getRoute()->getObject();
    if ($group->join($this->user))
    {
      $this->getUser()->setFlash('notice', 'Group joined.');
    }
    $this->redirect('sf_social_group', $group);
  }

  /**
   * Join a group by accepting an invite
   * @param sfRequest $request A request object
   */
  public function executeAccept(sfWebRequest $request)
  {
    $invite = $this->getRoute()->getObject();
    $this->forwardUnless($invite->getUserId() == $this->user->getId(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    if ($invite->getGroup()->join($this->user, $invite))
    {
      $this->getUser()->setFlash('notice', 'Group joined.');
    }
    $this->redirect('sf_social_group', $invite->getGroup());
  }

  /**
   * Deny an invite
   * @param sfRequest $request A request object
   */
  public function executeDeny(sfWebRequest $request)
  {
    $invite = $this->getRoute()->getObject();
    $this->forwardUnless($invite->getUserId() == $this->user->getId(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    if ($invite->refuse())
    {
      $this->getUser()->setFlash('notice', 'Invite refused.');
    }
    $this->redirect('sf_social_group', $invite->getGroup());
  }

}
