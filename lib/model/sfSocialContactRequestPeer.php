<?php

class sfSocialContactRequestPeer extends BasesfSocialContactRequestPeer
{
	/**
   * get request contacts of user
	 *
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getReceivedRequests(sfGuardUser $user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_TO, $user->getId());
		$c->add(self::ACCEPTED, false);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager = new sfPropelPager('sfSocialContactRequest', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUserRelatedByUserFrom');
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }

	/**
   * get send requests contacts of user
   *
	 * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getSendRequests(sfGuardUser $user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_FROM, $user->getId());
		$c->add(self::ACCEPTED, false);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager = new sfPropelPager('sfSocialContactRequest', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUserRelatedByUserFrom');
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }
}
