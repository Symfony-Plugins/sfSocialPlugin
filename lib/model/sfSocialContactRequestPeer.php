<?php

class sfSocialContactRequestPeer extends BasesfSocialContactRequestPeer
{
	/**
   * get contact request received by user
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
   * get contact requests sent by user
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getSentRequests(sfGuardUser $user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_FROM, $user->getId());
		$c->add(self::ACCEPTED, false);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager = new sfPropelPager('sfSocialContactRequest', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUserRelatedByUserTo');
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

	/**
   * get object by from/to users
   * @param  sfGuardUser            $from
   * @param  sfGuardUser            $to
   * @return sfSocialContactRequest
   */
  public static function retrieveByUsers(sfGuardUser $from, sfGuardUser $to)
  {
    $c = new Criteria;
    $c->add(self::USER_FROM, $from->getId());
    $c->add(self::USER_TO, $to->getId());

    return self::doSelectOne($c);
  }

}
