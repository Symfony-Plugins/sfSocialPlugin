<?php

/**
 * sfSocialGroupInvite
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialGroup
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class sfSocialGroupInvite extends BasesfSocialGroupInvite
{

  /**
   * refuse invite
   * @return boolean
   */
  public function refuse()
  {
    $this->setReplied(true);
    return $this->save() == 1;
  }

}
