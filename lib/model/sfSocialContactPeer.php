<?php

class sfSocialContactPeer extends BasesfSocialContactPeer
{
	/**
   * get messages contacts user
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getContacts(sfGuardUser $user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_TO, $user->getId());
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager = new sfPropelPager('sfSocialContact', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUserRelatedByUserTo');
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }

}
