<?php

class sfSocialMessage extends BasesfSocialMessage
{

  /**
   * check if user is in message's recipients
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserTo($user)
  {
    $rcpts = $this->getsfSocialMessageRcpts();
    foreach ($rcpts as $rcpt)
    {
      if ($rcpt->getUserTo() == $user->getId())
      {
        return true;
      }
    }
    return false;
  }

  /**
   * check if user is message's sender
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserFrom($user)
  {
    return $this->getUserFrom() == $user->getId();
  }

  /**
   * mark message as read
   * @param  sfGuardUser $user
   */
  public function read($user)
  {
    $rcpts = $this->getsfSocialMessageRcpts();
    foreach ($rcpts as $rcpt)
    {
      if ($rcpt->getUserTo() == $user->getId())
      {
        $rcpt->setIsRead(true);
        $rcpt->save();
      }
    }
  }

  /**
   * get message recipients' user names
   * @return boolean
   */
  public function getRcptUsers()
  {
    $rcpts = $this->getsfSocialMessageRcpts();
    foreach ($rcpts as $rcpt)
    {
      if ($rcpt->getUserTo() == $user->getId())
      {
        return true;
      }
    }
    return false;
  }

  /**
   * get subject for a reply
   * @return string
   */
  public function getReplySubject()
  {
    $re = 'Re: ';
    $subject = $this->getSubject();
    return substr($subject, 0, 4) == $re ? $subject : $re . $subject;
  }

  /**
   * save rcpt objects for message
   * @param array $rcpts
   */
  public function send($rcpts)
  {
    if (is_array($rcpts))
    {
      foreach ($rcpts as $user_to)
      {
        $rcpt = new sfSocialMessageRcpt;
        $rcpt->setsfSocialMessage($this);
        $rcpt->setUserTo($user_to);
        $rcpt->save();
      }
    }
  }

}
