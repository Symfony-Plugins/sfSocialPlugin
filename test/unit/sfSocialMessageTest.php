<?php

require_once dirname(__FILE__) . '/../bootstrap/unit.php';

$t = new lime_test(2, new lime_output_color());
$t->comment('sfSocialMessage->getReplySubject()');
$message = new sfSocialMessage;
$message->setSubject('lorem ipsum dolor sit amet');
$t->is($message->getReplySubject(), 'Re: lorem ipsum dolor sit amet', 'add "Re:" prefix');
$message->setSubject('Re: lorem ipsum dolor sit amet');
$t->is($message->getReplySubject(), 'Re: lorem ipsum dolor sit amet', 'do not duplicate prefix');
