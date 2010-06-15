<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$mike = sfGuardUserPeer::retrieveByUsername('mike');
$luigi = sfGuardUserPeer::retrieveByUsername('luigi');
$max = sfGuardUserPeer::retrieveByUsername('max');
$event1 = sfSocialEventPeer::retrieveByTitle('let\'s party!');
$event2 = sfSocialEventPeer::retrieveByTitle('I love pizza');
$event4 = sfSocialEventPeer::retrieveByTitle('End of the world');

$browser->

  doLogin()->

  info('index (list)')->
  get('/events/')->
  with('request')->begin()->
    isParameter('module', 'sfSocialEvent')->
    isParameter('action', 'list')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body h2', '/Events/')->
    // XXX this will work until 2012-12-21 :-)
    checkElement('ul#list li', time() > strtotime('2009-09-09 10:00:00') ? 1 : 2)->
  end()->

  info('single event')->
  click('End of the world')->
  with('request')->begin()->
    isParameter('module', 'sfSocialEvent')->
    isParameter('action', 'view')->
  end()->
  with('response')->begin()->
    checkElement('body h2', '/Event "End of the world"/')->
    checkElement('a[href$="/events"]', '/Back to list/')->
  end()->

  info('edit event')->
  click('Edit event')->
  with('request')->begin()->
    isParameter('module', 'sfSocialEvent')->
    isParameter('action', 'edit')->
  end()->
  click('edit', array('sf_social_event' => array(
    'title'       => '',
    'description' => '',
    'location'    => '',
  )))->
  with('form')->begin()->
    hasErrors(3)->
    isError('title', 'required')->
    isError('description', 'required')->
    isError('location', 'required')->
  end()->
  click('edit', array('sf_social_event' => array(
    'title'       => 'No more end!',
    'description' => 'I\'m a believer',
    'location'    => 'Earth',
  )))->
  with('form')->hasErrors(false)->
  with('propel')->begin()->
    check('sfSocialEvent', array(
      'title'       => 'No more end!',
      'description' => 'I\'m a believer',
      'location'    => 'Earth',
    ))->
  end()->

  info('confirm event')->
  with('response')->isRedirected()->followRedirect()->
  click('confirm', array('sf_social_event_user' => array(
    'confirm' => 2,
  )))->
  with('form')->hasErrors(false)->
  with('response')->begin()->
    checkElement('input[id=sf_social_event_user_confirm_2][checked=checked]')->
  end()->

  info('invite friend')->
  click('invite', array('sf_social_event_invite' => array(
    'user_id' => $luigi->getId(),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialEventInvite', array(
      'event_id'  => $event4->getId(),
      'user_id'   => $luigi->getId(),
      'user_from' => $max->getId(),
      'replied'   => false,
    ))->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('response')->begin()->
    checkElement('ul#invited li', true)->
  end()->

  info('invite an user that already confirmed')->
  get('/event/' . $event1->getId())->
  click('invite', array('sf_social_event_invite' => array(
    'user_id' => $mike->getId(),
  )))->
  with('propel')->begin()->
    check('sfSocialEventInvite', array(
      'event_id'  => $event1->getId(),
      'user_id'   => $mike->getId(),
      'user_from' => $max->getId(),
      'replied'   => false,
    ), false)->
  end()->

  info('create a new event')->
  get('/event/create')->
  with('request')->begin()->
    isParameter('module', 'sfSocialEvent')->
    isParameter('action', 'create')->
  end()->
  click('create', array('sf_social_event' => array(
    'title'       => '',
    'description' => '',
    'location'    => '',
  )))->
  with('form')->begin()->
    hasErrors(3)->
    isError('title', 'required')->
    isError('description', 'required')->
    isError('location', 'required')->
  end()->
  click('create', array('sf_social_event' => array(
    'title'       => 'A new event',
    'description' => 'What about a new event?',
    'location'    => 'Just here!',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialEvent', array(
      'title'       => 'A new event',
      'description' => 'What about a new event?',
      'location'    => 'Just here!',
    ))->
  end()->

  info('check various invite replies')->
  get('/event/' . $event1->getId())->
  with('response')->begin()->
    checkElement('ul#confirmed li', 1)->
    checkElement('ul#maybe li', 1)->
    checkElement('ul#not li', 1)->
    checkElement('ul#invited li', 1)->
  end()->

  info('past event')->
  get('/event/' . $event1->getId())->
  with('response')->begin()->
    checkElement('a[href$="/pastevents"]', '/Back to list/')->
  end()->

  info('edit forbidden event')->
  get('/event/' . $event2->getId() . '/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()

;
