<?php

class sfSocialMessageRcpt extends BasesfSocialMessageRcpt
{
  /**
   * @return sfSocialMessage
   */
  public function getMessage()
  {
    return $this->getsfSocialMessage();
  }

  /**
   * @return sfGuardUser
   */
  public function getTo()
  {
    return $this->getsfGuardUser();
  }

}
