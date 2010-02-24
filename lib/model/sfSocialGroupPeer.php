<?php

class sfSocialGroupPeer extends BasesfSocialGroupPeer
{

  /**
   * get groups
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getGroups($page = 1, $n = 10)
  {
    $c = new Criteria();
    $pager = new sfPropelPager('sfSocialGroup', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  /**
   * get group by its title
   * @param  string        $title
   * @return sfSocialGroup
   */
  public static function retrieveByTitle($title)
  {
    $c = new Criteria;
    $c->add(self::TITLE, $title);

    return self::doSelectOne($c);
  }

}
