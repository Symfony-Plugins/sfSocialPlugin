<?php

/**
 * Base actions for the sfSocialPlugin sfSocialMessage module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialMessage
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
class BasesfSocialMessageActions extends sfActions
{

  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();
  }

  /**
   * List of received messages
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $this->pager = sfSocialMessageRcptPeer::getUserMessages($this->user,
                                                            $request->getParameter('page'));
    $this->unread = sfSocialMessageRcptPeer::countUnreadMessages($this->user);
  }

  /**
   * List of sent messages
   * @param sfRequest $request A request object
   */
  public function executeSentlist(sfWebRequest $request)
  {
    $this->pager = sfSocialMessageRcptPeer::getUserSentMessages($this->user,
                                                                $request->getParameter('page'));
  }

  /**
   * Read a received message
   * @param sfRequest $request A request object
   */
  public function executeRead(sfWebRequest $request)
  {
    $this->message = sfSocialMessagePeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($this->message, 'message not found');
    $this->rcpts = $this->message->getsfSocialMessageRcpts();
    $this->forward404Unless($this->message->checkUserTo($this->user),
                            'unauthorized');
    $this->message->read($this->user);
  }

  /**
   * Read a sent message
   * @param sfRequest $request A request object
   */
  public function executeSentread(sfWebRequest $request)
  {
    $this->message = sfSocialMessagePeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($this->message, 'message not found');
    $this->forward404Unless($this->message->checkUserFrom($this->user),
                            'unauthorized');
    $this->rcpts = $this->message->getsfSocialMessageRcpts();
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
      $this->forward404Unless($message->checkUserTo($this->user),
                              'unauthorized');
      $this->form->setDefault('to', $message->getsfGuardUser()->getId());
      $this->form->setDefault('subject', $message->getReplySubject());
    }
    if ($request->isMethod('post'))
    {
      $values = $request->getParameter('sf_social_message');
      $sent = $this->form->bindAndSave($values);
      $msg = $this->form->getObject();
      $msg->send($values['to']);
      if ($sent)
      {
        $this->dispatcher->notify(new sfEvent($msg, 'social.write_message'));
        $this->forward('sfSocialMessage', 'sent');
      }
    }
  }

  /**
   * Javascript for "Compose a new message"
   * @param sfRequest $request A request object
   */
  public function executeComposejs(sfWebRequest $request)
  {
  }

  /**
   * Message successfully sent
   * @param sfRequest $request A request object
   */
  public function executeSent(sfWebRequest $request)
  {
    $values = $request->getParameter('sf_social_message', array());
    $this->forward404Unless($values['to'], 'users not found');
    $this->to = sfGuardUserPeer::retrieveByPKs($values['to']);
  }

}
