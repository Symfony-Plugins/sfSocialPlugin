<?php

/**
 * Base actions for the sfSocialPlugin sfSocialEvent module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialEvent
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
abstract class BasesfSocialEventActions extends sfActions
{

 /**
  * List of events in which user is invited
  * @param sfRequest $request A request object
  */
  public function executeInvitedlist(sfWebRequest $request)
  {
    $page = $request->getParameter('page');
    $this->pager = sfSocialEventInvitePeer::getEvents($this->getUser()->getGuardUser(), $page);
  }

 /**
  * List of future events
  * @param sfRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page');
    $this->pager = sfSocialEventPeer::getEvents($page);
  }

 /**
  * List of past events
  * @param sfRequest $request A request object
  */
  public function executePastlist(sfWebRequest $request)
  {
    $page = $request->getParameter('page');
    $this->pager = sfSocialEventPeer::getPastEvents($page);
  }

 /**
  * View an event
  * @param sfRequest $request A request object
  */
  public function executeView(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless($id, 'id not passed');
    $this->event = sfSocialEventPeer::retrieveByPK($id);
    $this->forward404Unless($this->event, 'event not found');

    // confirm form
    $this->getContext()->set('Event', $this->event);
    $event_user = sfSocialEventUserPeer::retrieveByPK($this->event->getId(), $this->getUser()->getGuardUser()->getId());
    $this->form = new sfSocialEventUserForm($event_user);
    if ($request->isMethod('post'))
    {
      $this->form->bindAndSave($request->getParameter($this->form->getName()));
    }

    // invite form
    $this->isAdmin = $this->event->getSfGuardUser()->getId() == $this->getUser()->getGuardUser()->getId();
    if ($this->isAdmin)
    {
      $this->form2 = new sfSocialEventInviteForm();
    }
  }

 /**
  * Create a new event
  * @param sfRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new sfSocialEventForm();
    if ($request->isMethod('post'))
    {
      $values = $request->getParameter($this->form->getName());
      $created = $this->form->bindAndSave($values);
      $this->getContext()->set('Event', $this->form->getObject());
      $this->getContext()->set('isNew', true);
      $this->forwardIf($created, 'sfSocialEvent', 'created');
    }
  }

 /**
  * Event successfully created
  * @param sfRequest $request A request object
  */
  public function executeCreated(sfWebRequest $request)
  {
    $this->event = $this->getContext()->get('Event');
    $this->isNew = $this->getContext()->get('isNew');
    $values = $request->getParameter('sf_social_event', array());
  }

 /**
  * Edit an event
  * @param sfRequest $request A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->event = sfSocialEventPeer::retrieveByPK($id);
    $this->forward404Unless($this->event, 'event not found');
    $this->form = new sfSocialEventForm($this->event);
    if ($request->isMethod('post'))
    {
      $values = $request->getParameter($this->form->getName());
      $created = $this->form->bindAndSave($values);
      $this->getContext()->set('Event', $this->form->getObject());
      $this->getContext()->set('isNew', false);
      $this->forwardIf($created, 'sfSocialEvent', 'created');
    }
  }

 /**
  * Invite another user to an event
  * @param sfRequest $request A request object
  */
  public function executeInvite(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'), 'access denied');
    $values = $request->getParameter('sf_social_event_invite');
    $this->event = sfSocialEventPeer::retrieveByPK($values['event_id']);
    $this->forward404Unless($this->event, 'event not found');
    $this->getContext()->set('Event', $this->event);
    $this->form = new sfSocialEventInviteForm();
    $this->forward404If($this->event->getUserAdmin() != $values['user_from'], 'access denied');
    $this->form->bindAndSave($values);
  }

}
