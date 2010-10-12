<?php

class PluginsfSocialGroupInvitePeer extends BasesfSocialGroupInvitePeer
{
	/**
   * get object by tuple group_id/user_id/user_from
   * @param  sfSocialGroup       $group
   * @param  sfGuardUser         $to
   * @param  sfGuardUser         $from
   * @return sfSocialGroupInvite
   */
  public static function retrieveByInvite(sfSocialGroup $group, sfGuardUser $to, sfGuardUser $from)
  {
    $c = new Criteria;
    $c->add(self::GROUP_ID, $group->getId());
    $c->add(self::USER_ID, $to->getId());
    $c->add(self::USER_FROM, $from->getId());


    return self::doSelectOne($c);
  }
}
