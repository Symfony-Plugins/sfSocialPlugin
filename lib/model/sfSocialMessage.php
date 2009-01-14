<?php

class sfSocialMessage extends BasesfSocialMessage
{

  /**
   * check if message is belonging to user
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserTo($user)
  {
    return $this->getUserTo() == $user->getId();
  }

  /**
   * mark message as read
   */
  public function read()
  {
    $this->setRead(true);
    $this->save();
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

}
