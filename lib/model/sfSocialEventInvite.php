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
    return sfSocialEventUser::$choices[$eventUser->getConfirm()];
  }

}
