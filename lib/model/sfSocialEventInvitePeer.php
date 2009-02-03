<?php

class sfSocialEventInvitePeer extends BasesfSocialEventInvitePeer
{

  /**
   * get events in which user is invited
   * @param  sfGuardUser   $user
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getEvents($user, $page = 1, $n = 10)
  {
    $c = new Criteria();
    $c->add(self::USER_ID, $user->getId());
    $c->addDescendingOrderByColumn(sfSocialEventPeer::START);
    $pager = new sfPropelPager('sfSocialEventInvite', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinAllExceptsfGuardUserRelatedByUserId');
    $pager->setPage($page);
    $pager->init();
    return $pager;
  }

	/**
	 * This is identical to base classe method, except for:
	 *  $obj2->addsfSocialEventInvite($obj1);
	 * instead of
	 *  $obj2->addsfSocialEventInviteRelatedByUserId($obj1);
	 * (since the latter is non-existant... maybe a bug?)
	 *
	 * @param      Criteria  $c
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of sfSocialEventInvite objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptsfGuardUserRelatedByUserId(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfSocialEventInvitePeer::addSelectColumns($c);
		$startcol2 = (sfSocialEventInvitePeer::NUM_COLUMNS - sfSocialEventInvitePeer::NUM_LAZY_LOAD_COLUMNS);

		sfSocialEventPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (sfSocialEventPeer::NUM_COLUMNS - sfSocialEventPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(sfSocialEventInvitePeer::EVENT_ID,), array(sfSocialEventPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = sfSocialEventInvitePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = sfSocialEventInvitePeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$omClass = sfSocialEventInvitePeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				sfSocialEventInvitePeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined sfSocialEvent rows

				$key2 = sfSocialEventPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = sfSocialEventPeer::getInstanceFromPool($key2);
					if (!$obj2) {

						$omClass = sfSocialEventPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					sfSocialEventPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (sfSocialEventInvite) to the collection in $obj2 (sfSocialEvent)
				$obj2->addsfSocialEventInvite($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}

}
