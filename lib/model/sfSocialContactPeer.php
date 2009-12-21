<?php

class sfSocialContactPeer extends BasesfSocialContactPeer
{
	/**
   * get messages contacts user
   * @param  sfGuardUser $user
   * @param  integer     $page  current page
   * @param  integer     $n     max per page
   * @return sfPager
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
   * @param  sfGuardUser $user
   * @param  string      $text       text to search
   * @param  string      $excludeIds ids to exclude (e.g. "4,10,15")
   * @return array                   sfGuardUser objects
   */
  public static function search(sfGuardUser $user, $text, $excludeIds = null)
  {
    $c = new Criteria();
    $c->add(self::USER_FROM , $user->getId());
    $c->add(sfGuardUserPeer::USERNAME, '%' . $text . '%', Criteria::LIKE);
    if (!empty($excludeIds) && is_array($ids = explode(',', $excludeIds)))
    {
      $c->add(sfGuardUserPeer::ID, $ids, Criteria::NOT_IN);
    }
    $c->addAscendingOrderByColumn(sfGuardUserPeer::USERNAME);
    $c->setLimit(30);

    return self::doSelectJoinsfGuardUserRelatedByUserTo($c);
  }

	/**
   * get contacts shared by two users
   * @param  sfGuardUser $userFrom
   * @param  sfGuardUser $userTo
   * @param  integer     $limit
   * @return array                  sfSocialContact objects
   */
  public static function getSharedContacts(sfGuardUser $userFrom, sfGuardUser $userTo, $limit = 0)
  {
    $contactIdsFrom = self::getContactIds($userFrom);
    if (empty($contactIdsFrom))
    {
      return null;
    }
    $c = new Criteria;
    $c->add(self::USER_FROM, $userTo->getId());
    $c->add(self::USER_TO, $contactIdsFrom, Criteria::IN);
    if ($limit > 0)
    {
      $c->setLimit($limit);
    }

    return self::doSelectJoinsfGuardUserRelatedByUserTo($c);
  }

	/**
   * count contacts shared by two users
   * @param  sfGuardUser $userFrom
   * @param  sfGuardUser $userTo
   * @return integer
   */
  public static function countSharedContacts(sfGuardUser $userFrom, sfGuardUser $userTo)
  {
    $contactIdsFrom = self::getContactIds($userFrom);
    if (empty($contactIdsFrom))
    {
      return 0;
    }
    $c = new Criteria;
    $c->add(self::USER_FROM, $userTo->getId());
    $c->add(self::USER_TO, $contactIdsFrom, Criteria::IN);

    return self::doCount($c);
  }

  /**
   * get ids of contacts of an user
   * @param  sfGuardUser $user
   * @return array
   */
  public static function getContactIds(sfGuardUser $user)
  {
    $array = array();
    $c = new Criteria;
    $c->add(self::USER_FROM, $user->getId());
    $stmt = self::doSelectStmt($c);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $array[] = $row['USER_TO'];
    }

    return $array;
  }

}
