<?php

/**
 * Base actions for the sfSocialPlugin sfSocialEvent module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialEvent
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
class BasesfSocialEventActions extends sfActions
{

  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();
  }

 /**
  * List of events in which user is invited
  * @param sfRequest $request A request object
  */
  public function executeInvitedlist(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialEventInvitePeer::getEvents($this->user, $page);
  }

 /**
  * List of future events
  * @param sfRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialEventPeer::getEvents($page);
  }

 /**
  * List of past events
  * @param sfRequest $request A request object
  */
  public function executePastlist(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
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
    $eventUser = sfSocialEventUserPeer::retrieveByPK($this->event->getId(), $this->user->getId());
    $this->form = new sfSocialEventUserForm($eventUser, array('user' => $this->user,
                                                              'event' => $this->event));
    if ($request->isMethod('post'))
    {
      $this->form->bindAndSave($request->getParameter($this->form->getName()));
    }
    // invite form
    $this->isAdmin = $this->event->getSfGuardUser()->getId() == $this->user->getId();
    if ($this->isAdmin)
    {
      $this->form2 = new sfSocialEventInviteForm(null, array('user' => $this->user,
                                                             'event' => $this->event));
    }
  }

 /**
  * Create a new event
  * @param sfRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new sfSocialEventForm(null, array('user' => $this->user));
    if ($request->isMethod('post'))
    {
      $values = $request->getParameter($this->form->getName());
      if ($this->form->bindAndSave($values))
      {
        $this->getUser()->setFlash('notice', 'event created');
        $this->redirect('@sf_social_event?id=' . $this->form->getObject()->getId());
      }
    }
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
    $this->form = new sfSocialEventForm($this->event, array('user' => $this->user));
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
    $this->forward404Unless($request->isMethod('post'), 'invalid request');
    $values = $request->getParameter('sf_social_event_invite');
    $this->event = sfSocialEventPeer::retrieveByPK($values['event_id']);
    $this->forward404Unless($this->event, 'event not found');
    $this->getContext()->set('Event', $this->event);
    $this->form = new sfSocialEventInviteForm(null, array('user' => $this->user,
                                                          'event' => $this->event));
    $this->forwardUnless($this->event->getUserAdmin() == $values['user_from'],
                         'sfGuardAuth', 'secure');
    if ($this->form->bindAndSave($values))
    {
      $this->getUser()->setFlash('notice', count($this->form->getValue('user_id')) . ' users invited.');
    }
    $this->redirect('@sf_social_event?id=' . $this->event->getId());
  }

}
