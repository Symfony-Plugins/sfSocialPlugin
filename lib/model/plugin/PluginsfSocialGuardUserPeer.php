<?php

/**
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialGuardUser
 * @author     Lionel Guichard <lionel.guichard@gmail.com>
 */
class PluginsfSocialGuardUserPeer extends sfGuardUserPeer
{

	/**
   * search users
   * @param  string  $name name to search
   * @param  integer $page current page
   * @param  integer $n    max per page
   * @return sfPager
   */
  public static function search($name, $page = 1, $n = 10)
  {
    $c = new Criteria;
    $c->add(self::USERNAME, '%' . $name . '%', Criteria::LIKE);
    // TODO search in profile's fields too?
    $c->addAscendingOrderByColumn(sfGuardUserPeer::USERNAME);
    $pager = new sfPropelPager('sfGuardUser', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelect');
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

}
