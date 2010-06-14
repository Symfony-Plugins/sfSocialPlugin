<?php

require_once dirname(__FILE__) . '/../bootstrap/unit.php';

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true));

$t = new lime_test(4, array('options' => new lime_output_color(), 'error_reporting' => true));

$t->comment('sfSocialMessage->getReplySubject()');
$message = new sfSocialMessage;
$rcpt = new sfSocialMessageRcpt;
$message->setSubject('lorem ipsum dolor sit amet');
#$rcpt->setsfSocialMessage($message);
$t->is($message->getReplySubject(), 'Re: lorem ipsum dolor sit amet', 'add "Re:" prefix');
$message->setSubject('Re: lorem ipsum dolor sit amet');
$t->is($message->getReplySubject(), 'Re: lorem ipsum dolor sit amet', 'do not duplicate prefix');
#$t->comment('sfSocialMessage->read()');
#$t->is($rcpt->getIsRead(), false, 'message is unread');
$user = new sfGuardUser();
$user->setId(1);
$message->setUserFrom($user);
$rcpt->setUserTo($user);
#$message->read($user);
#$t->is($rcpt->getRead(), true, 'message is read');
$t->comment('sfSocialMessage->checkUserTo()');
$t->is($message->checkUserFrom($user), true, 'User is correct');
$user2 = new sfGuardUser();
$user2->setId(2);
$t->is($message->checkUserFrom($user2), false, 'User is uncorrect');
