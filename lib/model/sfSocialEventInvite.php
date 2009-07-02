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
    $event_user = sfSocialEventUserPeer::retrieveByPK($event->getId(), $user->getId());
    if (null === $event_user)
    {
      return null;
    }
    return sfSocialEventUser::$choices[$event_user->getConfirm()];
  }

}
