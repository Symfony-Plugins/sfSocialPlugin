<?php

class sfSocialEvent extends BasesfSocialEvent
{

  /**
   * magic method
   * @return string
   */
  public function __toString()
  {
    return $this->getTitle();
  }

  /**
   * get start and end dates in a fancy format
   * @param  string $dateF date format
   * @param  string $timeF time format
   * @return string
   */
  public function getWhen($dateF = 'd/m/Y', $timeF = 'H:i')
  {
    // event starts and ends in same day
    if ($this->getStart('zY') == $this->getEnd('zY'))
    {
      $string = '%day% from %starttime% to %endtime%';
      $params = array('%day%'       => $this->getStart($dateF),
                      '%starttime%' => $this->getStart($timeF),
                      '%endtime%'   => $this->getEnd($timeF));
    }
    else
    {
    // event spans in more days
      $string = 'from %startdaytime% to %enddatetime%';
      $params = array('%startdaytime%' => $this->getStart($dateF . ' ' . $timeF),
                      '%enddatetime%'  => $this->getEnd($dateF . ' ' . $timeF));
    }
    // possibly localize string
    if (sfConfig::get('sf_i18n'))
    {
      $i18n = sfContext::getInstance()->getI18N();
      return $i18n->__($string, $params, 'sfSocial');
    }
    else
    {
      return strtr($string, $params);
    }
  }

  /**
   * check if an user is admin of event
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isAdmin(sfGuardUser $user)
  {
    return $this->getUserAdmin() == $user->getId();
  }

  /**
   * get confirmed users
   * @return array
   */
  public function getConfirmedUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_YES);
    return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }

  /**
   * get users that replied "maybe"
   * @return array
   */
  public function getMaybeUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_MAYBE);
    return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }

  /**
   * get users that replied "no"
   * @return array
   */
  public function getNoUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_NO);
    return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }

  /**
   * get users awaiting reply
   * @return array
   */
  public function getAwaitingReplyUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventInvitePeer::REPLIED, false);
    return $this->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId($c);

  }

}
