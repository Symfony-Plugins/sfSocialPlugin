<?php

/**
 * sfSocialNotifyListener class. Contains listeners to
 * other sfSocialPlugin's modules
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialNotify
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */

class sfSocialNotifyListener
{

  /**
   * Listen to social.write_message event
   * When a message is sent, notify recipients
   * @param sfEvent An sfEvent instance
   */
  static public function listenToWriteMessage(sfEvent $event)
  {
    $msg = $event->getSubject();
    foreach ($msg->getRcpts() as $rcpt)
    {
      $notify = new sfSocialNotify;
      $notify->notifyMessage($msg, $rcpt);
    }
  }

  /**
   * Listen to social.event_inite event
   * When a message is sent, notify recipients
   * @param sfEvent An sfEvent instance
   */
  static public function listenToEventInvite(sfEvent $event)
  {
    $invites = $event->getSubject();
    foreach ($invites as $inv)
    {
      $notify = new sfSocialNotify;
      $notify->notifyEventInvite($inv);
    }
  }

  /**
   * Listen to social.group_inite event
   * When a message is sent, notify recipients
   * @param sfEvent An sfEvent instance
   */
  static public function listenToGroupInvite(sfEvent $event)
  {
    $invites = $event->getSubject();
    foreach ($invites as $inv)
    {
      $notify = new sfSocialNotify;
      $notify->notifyGroupInvite($inv);
    }
  }

  /**
   * Listen to social.contact_request event
   * When a message is sent, notify recipients
   * @param sfEvent An sfEvent instance
   */
  static public function listenToContactRequest(sfEvent $event)
  {
    $contactRequest = $event->getSubject();
    $notify = new sfSocialNotify;
    $notify->notifyContactRequest($contactRequest);
  }

}