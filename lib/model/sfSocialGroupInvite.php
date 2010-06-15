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

  /**
   * @return sfSocialGroup
   */
  public function getGroup()
  {
    return $this->getsfSocialGroup();
  }

  /**
   * @return sfGuardUser
   */
  public function getFrom()
  {
    return $this->getsfGuardUserRelatedByUserFrom();
  }

}
