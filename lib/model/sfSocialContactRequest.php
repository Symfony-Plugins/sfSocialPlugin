<?php

class sfSocialContactRequest extends BasesfSocialContactRequest
{
	/**
   * check if request is belonging to user
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserFrom($user)
  {
    return $this->getUserTo() == $user->getId();
  }

  /**
   * mark request as accept
   */
  public function accepted()
  {
    $this->setAccepted(true);
    $this->save();
  }
  
  /**
   * mark request as refused
   */
  public function refused()
  {
    $this->delete();
  }
}
