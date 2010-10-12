<?php

class PluginsfSocialMessageRcpt extends BasesfSocialMessageRcpt
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
