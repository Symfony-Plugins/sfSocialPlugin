<?php

class sfSocialEventInvite extends BasesfSocialEventInvite
{
  /**
   * get user's reply to event invite
   * @return string
   */
  public function getReply()
  {
    $event = $this->getsfSocialEvent();
    $user = $this->getsfGuardUserRelatedByUserId();
    $eventUser = sfSocialEventUserPeer::retrieveByPK($event->getId(), $user->getId());
    if (null === $eventUser)
    {
      return null;
    }
    $choices = sfSocialEventUserPeer::$confirmChoices;
    return $choices[$eventUser->getConfirm()];
  }

  /**
   * get other invites sent with current one
   * @return array
   */
  public function getAllInvites()
  {
    $c = new Criteria;
    $c->add(sfSocialEventInvitePeer::CREATED_AT, time(), Criteria::GREATER_EQUAL);
    return $this->getsfSocialEvent()->getsfSocialEventInvites($c);
  }

  /**
   * @return sfSocialEvent
   */
  public function getEvent()
  {
    return $this->getsfSocialEvent();
  }

  /**
   * @return sfGuardUser
   */
  public function getFrom()
  {
    return $this->getsfGuardUserRelatedByUserFrom();
  }

  /**
   * @return sfGuardUser
   */
  public function getTo()
  {
    return $this->getsfGuardUserRelatedByUserId();
  }

}
