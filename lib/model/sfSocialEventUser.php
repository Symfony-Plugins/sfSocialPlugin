<?php

/**
 * sfSocialEventUser
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialEvent
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class sfSocialEventUser extends BasesfSocialEventUser
{
  /**
   * @return sfGuardUser
   */
  public function getUser()
  {
    return $this->getsfGuardUser();
  }
}
