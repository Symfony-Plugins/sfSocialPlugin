<?php

/**
 * sfSocialGroup
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialGroup
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class PluginsfSocialGroup extends BasesfSocialGroup
{

  /**
   * magic method
   * @return string
   */
  public function __toString()
  {
    return $this->getTitle();
  }

  /**
   * check if an user is admin of group
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isAdmin(sfGuardUser $user)
  {
    return $this->getUserAdmin() == $user->getId();
  }

  /**
   * check if an user is member of group
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isMember(sfGuardUser $user)
  {
    $c = new Criteria;
    $c->add(sfSocialGroupUserPeer::GROUP_ID, $this->getId());
    $c->add(sfSocialGroupUserPeer::USER_ID, $user->getId());

    return sfSocialGroupUserPeer::doCount($c) > 0;
  }

  /**
   * check if an user is invited to group
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isInvited(sfGuardUser $user)
  {
    $c = new Criteria;
    $c->add(sfSocialGroupInvitePeer::GROUP_ID, $this->getId());
    $c->add(sfSocialGroupInvitePeer::USER_ID, $user->getId());
    $c->add(sfSocialGroupInvitePeer::REPLIED, false);

    return sfSocialGroupInvitePeer::doCount($c) > 0;
  }

  /**
   * join an user to group
   * @param  sfGuardUser         $user
   * @param  sfSocialGroupInvite $invite if not null, set invite as accepted
   * @return boolean
   */
  public function join(sfGuardUser $user, sfSocialGroupInvite $invite = null)
  {
    try
    {
      $groupUser = new sfSocialGroupUser;
      $groupUser->setsfGuardUser($user);
      $groupUser->setsfSocialGroup($this);
      if (!empty($invite))
      {
        $invite->setReplied(true);
        $invite->save();
      }
      return $groupUser->save() == 1;
    }
    catch (PropelException $e)
    {
      return false;
    }
  }

  /**
   * get invite of an user to join group
   * @param  sfGuardUser    $user
   * @return sfSocialInvite
   */
  public function getInvite(sfGuardUser $user)
  {
    $c = new Criteria;
    $c->add(sfSocialGroupInvitePeer::GROUP_ID, $this->getId());
    $c->add(sfSocialGroupInvitePeer::USER_ID, $user->getId());
    $c->add(sfSocialGroupInvitePeer::REPLIED, false);

    return sfSocialGroupInvitePeer::doSelectOne($c);
  }

  /**
   * get invited users (only ones that did not reply)
   * @return array sfSocialGroupInvite objects
   */
  public function getInvitedUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialGroupInvitePeer::REPLIED, false);

    return $this->getsfSocialGroupInvitesJoinTo($c);
  }

  /**
   * @return array
   */
  public function getUsers()
  {
    return $this->getsfSocialGroupUsers();
  }
}
