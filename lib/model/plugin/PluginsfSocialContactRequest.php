<?php

class PluginsfSocialContactRequest extends BasesfSocialContactRequest
{
	/**
   * check if request is belonging to user
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserFrom($user)
  {
    return $this->getUserFrom() == $user->getId();
  }

	/**
   * check if request is directed to user
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserTo($user)
  {
    return $this->getUserTo() == $user->getId();
  }

  /**
   * mark request as accept
   */
  public function accept()
  {
    $this->setAccepted(true);
    $this->save();
  }

  /**
   * mark request as refused
   */
  public function refuse()
  {
    $this->delete();
  }

  /**
   * cancel a sent request
   */
  public function cancel()
  {
    $this->delete();
  }

  /**
   * @return sfGuardUser
   */
  public function getFrom()
  {
    return $this->getsfGuardUserRelatedByUserFrom();
  }

  /**
   * @return sfGuardUser
   */
  public function getTo()
  {
    return $this->getsfGuardUserRelatedByUserTo();
  }

}
