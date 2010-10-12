<?php

class PluginsfSocialMessageRcptPeer extends BasesfSocialMessageRcptPeer
{

  /**
   * get messages received by user
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getUserMessages(sfGuardUser $user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_TO, $user->getId());
    $c->addDescendingOrderByColumn(sfSocialMessagePeer::CREATED_AT);
    $pager = new sfPropelPager('sfSocialMessageRcpt', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinAll');
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  /**
   * get messages sent by user
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getUserSentMessages(sfGuardUser $user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(sfSocialMessagePeer::USER_FROM, $user->getId());
    #$c->addSelectColumn('COUNT(*)');
    $c->addAsColumn('number', 'COUNT(*)');
    $c->addGroupByColumn(self::MSG_ID);
    $c->addDescendingOrderByColumn(sfSocialMessagePeer::CREATED_AT);
    $pager = new sfPropelPager('sfSocialMessageRcpt', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinAll');
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  /**
   * get number of unread messages of user
   * @param  sfGuardUser   $user
   * @return integer
   */
  public static function countUnreadMessages(sfGuardUser $user)
  {
    $c = new Criteria();
    $c->add(self::USER_TO, $user->getId());
    $c->add(self::IS_READ, false);
    
    return self::doCount($c);
  }

}
