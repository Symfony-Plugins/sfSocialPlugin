<?php

/**
 * sfSocialEventUser
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialEvent
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class sfSocialEventUser extends BasesfSocialEventUser
{

  // possible replies to invite

  const REPLY_MAYBE = 1;
  const REPLY_YES   = 2;
  const REPLY_NO    = 3;

  public static $choices = array(self::REPLY_MAYBE => 'maybe',
                                 self::REPLY_YES   => 'yes',
                                 self::REPLY_NO    => 'no');

}
