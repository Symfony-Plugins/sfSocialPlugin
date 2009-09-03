<?php

class sfSocialEventUserPeer extends BasesfSocialEventUserPeer
{
  // possible replies to invite

  const REPLY_MAYBE = 1;
  const REPLY_YES   = 2;
  const REPLY_NO    = 3;

  static public $confirmChoices = array(self::REPLY_MAYBE => 'maybe',
                                        self::REPLY_YES   => 'yes',
                                        self::REPLY_NO    => 'no');
}
