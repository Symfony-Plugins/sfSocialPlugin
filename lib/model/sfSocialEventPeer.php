<?php

class sfSocialEventPeer extends BasesfSocialEventPeer
{

  /**
   * get events
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getEvents($page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::END, time(), Criteria::GREATER_EQUAL);
    $c->addDescendingOrderByColumn(self::START);
    $pager = new sfPropelPager('sfSocialEvent', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->setPage($page);
    $pager->init();
    
    return $pager;
  }

  /**
   * get past events
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getPastEvents($page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::END, time(), Criteria::LESS_THAN);
    $c->addDescendingOrderByColumn(self::START);
    $pager = new sfPropelPager('sfSocialEvent', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

}
