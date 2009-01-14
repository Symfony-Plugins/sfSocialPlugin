<?php

/**
 * Base actions for the sfSocialPlugin sfSocialMessage module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialMessage
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
abstract class BasesfSocialMessageActions extends sfActions
{

 /**
  * List of received messages
  * @param sfRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page');
    $this->pager = sfSocialMessagePeer::getUserMessages($this->getUser()->getGuardUser(), $page);
    $this->unread = sfSocialMessagePeer::countUnreadMessages($this->getUser()->getGuardUser());
  }

 /**
  * List of sent messages
  * @param sfRequest $request A request object
  */
  public function executeSentlist(sfWebRequest $request)
  {
    $page = $request->getParameter('page');
    $this->pager = sfSocialMessagePeer::getUserSentMessages($this->getUser()->getGuardUser(), $page);
  }

 /**
  * Read a received message
  * @param sfRequest $request A request object
  */
  public function executeRead(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless($id, 'id not passed');
    $this->message = sfSocialMessagePeer::retrieveByPK($id);
    $this->forward404Unless($this->message, 'message not found');
    $this->forward404Unless($this->message->checkUserTo($this->getUser()->getGuardUser()),
                            'unauthorized');
    $this->message->read();
  }

 /**
  * Read a sent message
  * @param sfRequest $request A request object
  */
  public function executeSentread(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $this->forward404Unless($id, 'id not passed');
    $this->message = sfSocialMessageSentPeer::retrieveByPK($id);
    $this->forward404Unless($this->message, 'message not found');
    $this->forward404Unless($this->message->checkUserFrom($this->getUser()->getGuardUser()),
                            'unauthorized');
  }

 /**
  * Compose a new message
  * @param sfRequest $request A request object
  */
  public function executeCompose(sfWebRequest $request)
  {
    $this->form = new sfSocialMessageForm();
    // possible reply
    $reply_to = $request->getParameter('reply_to');
    if ($reply_to)
    {
      $message = sfSocialMessagePeer::retrieveByPK($reply_to);
      $this->forward404Unless($message, 'message not found');
      $this->forward404Unless($message->checkUserTo($this->getUser()->getGuardUser()),
                              'unauthorized');
      $this->form->setDefault('user_to', $message->getsfGuardUserRelatedByUserFrom()->getId());
      $this->form->setDefault('subject', $message->getReplySubject());
    }
    if ($request->isMethod('post'))
    {
      $values = $request->getParameter('sf_social_message');
      $sent = $this->form->bindAndSave($values);
      $this->forwardIf($sent, 'sfSocialMessage', 'sent');
    }
  }

 /**
  * Message successfully sent
  * @param sfRequest $request A request object
  */
  public function executeSent(sfWebRequest $request)
  {
    $values = $request->getParameter('sf_social_message', array());
    $this->forward404Unless($values['user_to'], 'user not found');
    $to = sfGuardUserPeer::retrieveByPK($values['user_to']);
    $this->to = $to->getUsername();
  }

}
