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
    $this->message = $this->getRoute()->getObject();
    $this->forwardUnless($this->message->checkUserTo($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->rcpts = $this->message->getRcpts();
    $this->message->read($this->user);
  }

  /**
   * Read a sent message
   * @param sfRequest $request A request object
   */
  public function executeSentread(sfWebRequest $request)
  {
    $this->message = $this->getRoute()->getObject();
    $this->forwardUnless($this->message->checkUserFrom($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->rcpts = $this->message->getRcpts();
  }

  /**
   * Compose a new message
   * @param sfRequest $request A request object
   */
  public function executeCompose(sfWebRequest $request)
  {
    $replyTo = $request->getParameter('reply_to');
    $to = $request->getParameter('to');
    // check if it's a reply message
    if (null !== $replyTo)
    {
      $message = sfSocialMessagePeer::retrieveByPK($replyTo);
      $this->forward404Unless($message, 'message not found');
      $this->forwardUnless($message->checkUserTo($this->user), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
      $this->form = new sfSocialMessageForm(null, array('user' => $this->user,
                                                        'reply_to' => $message));
    }
    // possible recipient passed via parameter
    elseif (null !== $to)
    {
      $rcptUser = sfGuardUserPeer::retrieveByUsername($to);
      $this->forward404Unless($rcptUser, 'recipient user not found');
      $this->form = new sfSocialMessageForm(null, array('user' => $this->user, 'to' => $rcptUser));
    }
    else
    {
      $this->form = new sfSocialMessageForm(null, array('user' => $this->user));
    }
    // send message
    if ($request->isMethod(sfRequest::POST))
    {
      $values = $request->getParameter($this->form->getName());
      if ($this->form->bindAndSave($values))
      {
        $msg = $this->form->getObject();
        $msg->send($values['to']);
        $this->dispatcher->notify(new sfEvent($msg, 'social.write_message'));
        $this->to = sfGuardUserPeer::retrieveByPKs($values['to']);
        $this->setTemplate('sent');
      }
    }
  }

}
