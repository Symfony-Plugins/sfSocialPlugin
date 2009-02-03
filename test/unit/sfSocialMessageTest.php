<?php

require_once dirname(__FILE__) . '/../bootstrap/unit.php';

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true));

$t = new lime_test(6, new lime_output_color());
$t->comment('sfSocialMessage->getReplySubject()');
$message = new sfSocialMessage;
$message->setSubject('lorem ipsum dolor sit amet');
$t->is($message->getReplySubject(), 'Re: lorem ipsum dolor sit amet', 'add "Re:" prefix');
$message->setSubject('Re: lorem ipsum dolor sit amet');
$t->is($message->getReplySubject(), 'Re: lorem ipsum dolor sit amet', 'do not duplicate prefix');
$t->comment('sfSocialMessage->read()');
$t->is($message->getRead(), false, 'message is unread');
$user = new sfGuardUser();
$user->setId(1);
$message->setUserFrom($user);
$message->setUserTo($user);
$message->read();
$t->is($message->getRead(), true, 'message is read');
$t->comment('sfSocialMessage->checkUserTo()');
$t->is($message->checkUserTo($user), true, 'User is correct');
$user2 = new sfGuardUser();
$user2->setId(2);
$t->is($message->checkUserTo($user2), false, 'User is uncorrect');
