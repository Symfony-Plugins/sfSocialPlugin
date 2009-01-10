<?php

class sfSocialMessageSent extends BasesfSocialMessageSent
{

  /**
   * check if message is belonging to user
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserFrom($user)
  {
    return $this->getUserFrom() == $user->getId();
  }

}
