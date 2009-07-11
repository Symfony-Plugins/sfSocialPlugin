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
    $c->add(self::USER_FROM, $user->getId());
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager = new sfPropelPager('sfSocialContact', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUserRelatedByUserTo');
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }

	/**
   * search user's contacts (possibly exlcuding someones)
   * @param  sfGuardUser   $user
   * @param  string        $text        text to search
   * @param  string        $exclude_ids ids to exclude (e.g. "4,10,15")
   * @return array
   */
  public static function search(sfGuardUser $user, $text, $exclude_ids = array())
  {
    $c = new Criteria();
    $c->add(self::USER_FROM , $user->getId());
    $c->add(sfGuardUserPeer::USERNAME, '%' . $text . '%', Criteria::LIKE);
    if (!empty($exclude_ids))
    {
      $c->add(sfGuardUserPeer::ID, explode(',', $exclude_ids), Criteria::NOT_IN);
    }
    $c->addAscendingOrderByColumn(sfGuardUserPeer::USERNAME);
    $c->setLimit(30);
    return self::doSelectJoinsfGuardUserRelatedByUserTo($c);
  }

}
