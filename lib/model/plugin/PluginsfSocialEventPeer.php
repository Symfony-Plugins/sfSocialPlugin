<?php

class PluginsfSocialEventPeer extends BasesfSocialEventPeer
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
    $pager->setPeerMethod('doSelectJoinAdmin');
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

  /**
   * get event by its title (warning: title is NOT unique)
   * @param  string        $title
   * @return sfSocialEvent
   */
  public static function retrieveByTitle($title)
  {
    $c = new Criteria;
    $c->add(self::TITLE, $title);

    return self::doSelectOne($c);
  }

}
