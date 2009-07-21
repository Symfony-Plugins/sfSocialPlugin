<?php

class sfSocialNotify extends BasesfSocialNotify
{

  /**
   * @var mixed object of one type between sfSocialMessage, sfSocialEvent,
   *             sfSocialGroup, sfSocialContact
   */
  protected $model;

  /**
   * notify a message received
   * @param sfSocialMessage     $msg
   * @param sfSocialMessageRcpt $rcpt
   */
  public function notifyMessage(sfSocialMessage $msg, sfSocialMessageRcpt $rcpt)
  {
    $this->setUserId($rcpt->getUserTo());
    $this->setModelName('sfSocialMessage');
    $this->setModelId($msg->getId());
    $this->save();
  }

  /**
   * set model
   */
  public function setModel()
  {
    switch ($this->getModelName())
    {
      case 'sfSocialMessage':
        $msg = sfSocialMessagePeer::retrieveByPK($this->getModelId());
        $this->model = empty($msg) ? new sfSocialMessage : $msg;
        break;
      case 'sfSocialContactRequest':
        $request = sfSocialContactRequestPeer::retrieveByPK($this->getModelId());
        $this->model = empty($request) ? new sfSocialContactRequest : $request;
        break;
      case 'sfSocialEventInvite':
        $invite = sfSocialEventInvitePeer::retrieveByPK($this->getModelId());
        $this->model = empty($invite) ? new sfSocialEventInvite : $invite;
        break;
      case 'sfSocialGroupInvite':
        $invite = sfSocialGroupInvitePeer::retrieveByPK($this->getModelId());
        $this->model = empty($invite) ? new sfSocialGroupInvite : $invite;
    }
  }

  /**
   * get model
   * @return mixed an object (see $model)
   */
  public function getModel()
  {
    return $this->model;
  }

  /**
   * mark notify as read
   */
  public function read()
  {
    $this->setIsRead(true);
    $this->save();
  }

  /**
   * notify a contact request received
   * @param sfSocialContactRequest $request
   */
  public function notifyContactRequest(sfSocialContactRequest $request)
  {
    $this->setUserId($request->getUserTo());
    $this->setModelName('sfSocialContactRequest');
    $this->setModelId($request->getId());
    $this->save();
  }

  /**
   * notify an event invite received
   * @param sfSocialEventInvite $invite
   */
  public function notifyEventInvite(sfSocialEventInvite $invite)
  {
    $this->setUserId($invite->getUserId());
    $this->setModelName('sfSocialEventInvite');
    $this->setModelId($invite->getId());
    $this->save();
  }

  /**
   * notify a groupinvite received
   * @param sfSocialGroupInvite $invite
   */
  public function notifyGroupInvite(sfSocialGroupInvite $invite)
  {
    $this->setUserId($invite->getUserId());
    $this->setModelName('sfSocialGroupInvite');
    $this->setModelId($invite->getId());
    $this->save();
  }

}
