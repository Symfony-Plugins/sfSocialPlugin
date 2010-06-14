<?php

require_once dirname(__FILE__) . '/../bootstrap/unit.php';

$t = new lime_test(2, array('options' => new lime_output_color(), 'error_reporting' => true));
$t->comment('sfSocialEvent->getWhen()');
$event = new sfSocialEvent;
$event->setStart('2009-01-10 11:00:00');
$event->setEnd('2009-01-10 18:30:00');
$t->is($event->getWhen(), '10/01/2009 from 11:00 to 18:30', 'event starts and ends in same day');
$event->setEnd('2009-01-12 11:30:00');
$t->is($event->getWhen(), 'from 10/01/2009 11:00 to 12/01/2009 11:30', 'event spans in more days');
