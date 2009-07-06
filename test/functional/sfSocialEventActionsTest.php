<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

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
  with('form')->begin()->hasErrors(3)->
    isError('title', 'required')->
    isError('description', 'required')->
    isError('location', 'required')->
  end()->
  click('edit', array('sf_social_event' => array(
    'title'       => 'No more end!',
    'description' => 'I\'m a believer',
    'location'    => 'Earth',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialEvent', array(
      'title'       => 'No more end!',
      'description' => 'I\'m a believer',
      'location'    => 'Earth',
  ))->
  end()->

  info('confirm event')->
  isRedirected()->
  followRedirect()->
  click('confirm', array('sf_social_event_user' => array(
    'confirm' => '2',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()
;

$browser->test()->is($browser->getResponseDom()->getElementById('sf_social_event_user_confirm_2')->getAttribute('checked'), 'checked', '"yes" is now checked');

$browser->

  info('invite friend')->
  click('invite', array('sf_social_event_invite' => array(
    'user_id' => '5',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
    followRedirect()->
    with('response')->begin()->
    checkElement('ul#invited li', true)->
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
  with('form')->begin()->hasErrors(3)->
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

  info('edit forbidden event')->
  get('/event/2/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()

;
