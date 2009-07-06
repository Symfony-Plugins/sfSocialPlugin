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
   * List of groups
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialGroupPeer::getGroups($page);
  }

  /**
   * View a a group
   * @param sfRequest $request A request object
   */
  public function executeView(sfWebRequest $request)
  {
    $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($this->group, 'group not found');
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
    $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($this->group, 'group not found');
    $this->forwardUnless($this->group->isAdmin($this->user), 'sfGuardAuth', 'secure');
    $this->form = new sfSocialGroupForm($this->group, array('user' => $this->user));
    if ($request->isMethod('post'))
    {
      if ($this->form->bindAndSave($request->getParameter($this->form->getName())))
      {
        $this->getUser()->setFlash('notice', 'group modified');
        $this->redirect('@sf_social_group?id=' . $this->form->getObject()->getId());
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
    if ($request->isMethod('post'))
    {
      if ($this->form->bindAndSave($request->getParameter($this->form->getName())))
      {
        $this->getUser()->setFlash('notice', 'group created');
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
    $this->forward404Unless($request->isMethod('post'), 'invalid request');
    $values = $request->getParameter('sf_social_group_invite');
    $this->group = sfSocialGroupPeer::retrieveByPK($values['group_id']);
    $this->forward404Unless($this->group, 'group not found');
    $this->forwardUnless($this->group->isAdmin($this->user), 'sfGuardAuth', 'secure');
    $this->form = new sfSocialGroupInviteForm(null, array('user' => $this->user,
                                                          'group' => $this->group));
    if ($this->form->bindAndSave($values))
    {
      $this->getUser()->setFlash('notice', count($this->form->getValue('user_id')) . ' users invited.');
    }
    $this->redirect('@sf_social_group?id=' . $this->group->getId());
  }

  /**
   * Join a group directly
   * @param sfRequest $request A request object
   */
  public function executeJoin(sfWebRequest $request)
  {
    $group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($group, 'group not found');
    if ($group->join($this->user))
    {
      $this->getUser()->setFlash('notice', 'Group joined.');
    }
    $this->redirect('@sf_social_group?id=' . $group->getId());
  }

  /**
   * Join a group by accepting an invite
   * @param sfRequest $request A request object
   */
  public function executeAccept(sfWebRequest $request)
  {
    $invite = sfSocialGroupInvitePeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($invite, 'invite not found');
    $this->forwardUnless($invite->getUserId() == $this->user->getId(), 'sfGuardAuth', 'secure');
    if ($invite->getsfSocialGroup()->join($this->user, $invite))
    {
      $this->getUser()->setFlash('notice', 'Group joined.');
    }
    $this->redirect('@sf_social_group?id=' . $invite->getsfSocialGroup()->getId());
  }

  /**
   * Deny an invite
   * @param sfRequest $request A request object
   */
  public function executeDeny(sfWebRequest $request)
  {
    $invite = sfSocialGroupInvitePeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($invite, 'invite not found');
    $this->forwardUnless($invite->getUserId() == $this->user->getId(), 'sfGuardAuth', 'secure');
    if ($invite->refuse())
    {
      $this->getUser()->setFlash('notice', 'Invite refused.');
    }
    $this->redirect('@sf_social_group?id=' . $invite->getsfSocialGroup()->getId());
  }

}
