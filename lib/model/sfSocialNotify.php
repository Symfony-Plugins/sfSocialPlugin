<?php

class sfSocialNotify extends BasesfSocialNotify
{

  /**
   * @var mixed sfSocialMessage object, or sfSocialEvent object, etc.
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
      // TODO other models
    }
  }

  /**
   * get model
   * @return mixed sfSocialMessage object, or sfSocialEvent object, etc.
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
    $this->setRead(true);
    $this->save();
  }

}
