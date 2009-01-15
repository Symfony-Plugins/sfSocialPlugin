<?php

class sfSocialEventInvitePeer extends BasesfSocialEventInvitePeer
{

  /**
   * get events in which user is invited
   * TODO there's a bug here?
   *      http://www.symfony-project.org/forum/index.php/m/69920/#msg_69920
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getEvents($user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_ID, $user->getId());
    $c->addDescendingOrderByColumn(sfSocialEventPeer::START);
    #$c->addAlias('u1', sfGuardUserPeer::TABLE_NAME);
    $pager = new sfPropelPager('sfSocialEventInvite', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinAllExceptsfGuardUserRelatedByUserFrom');
    #$pager->setPeerMethod('doSelectJoinAll');
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }

}
