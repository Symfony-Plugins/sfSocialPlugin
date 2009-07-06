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

}
