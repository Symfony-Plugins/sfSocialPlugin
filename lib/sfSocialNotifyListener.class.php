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
   * Listens to social.write_message event
   * When a message is sent, notify recipients
   * @param sfEvent An sfEvent instance
   */
  static public function listenToWriteMessage(sfEvent $event)
  {
    $msg = $event->getSubject();
    foreach ($msg->getSfSocialMessageRcpts() as $rcpt)
    {
      $notify = new sfSocialNotify;
      $notify->notifyMessage($msg, $rcpt);
    }
  }

}