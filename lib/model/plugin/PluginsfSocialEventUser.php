<?php

/**
 * sfSocialEventUser
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialEvent
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class PluginsfSocialEventUser extends BasesfSocialEventUser
{
  /**
   * @return sfGuardUser
   */
  public function getUser()
  {
    return $this->getsfGuardUser();
  }
}
