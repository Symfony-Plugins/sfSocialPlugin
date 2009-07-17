<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$browser->

  doLogin()->

  info('notify a new message')->
  get('/message/compose')->
  click('send', array('sf_social_message' => array(
    'subject' => 'hello',
    'text'    => 'just a test',
    'to'      => array(1, 2),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 1,
      'model_name' => 'sfSocialMessage',
      'model_id'   => 7,
      'read'       => false,
  ))->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 2,
      'model_name' => 'sfSocialMessage',
      'model_id'   => 7,
      'read'       => false,
  ))->
  end()->

  info('notify a contact request')->
  get('/request/send')->
  click('send', array('sf_social_contact_request' => array(
    'user_to' => 1,
    'message' => 'just a test'
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 1,
      'model_name' => 'sfSocialContactRequest',
      'model_id'   => 4,
      'read'       => false,
  ))->
  end()->

  info('notify a group invite')->
  get('/group/1')->
  click('invite', array('sf_social_group_invite' => array(
    'user_id' => array(1, 2),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 1,
      'model_name' => 'sfSocialGroupInvite',
      'model_id'   => 5,
      'read'       => false,
  ))->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 2,
      'model_name' => 'sfSocialGroupInvite',
      'model_id'   => 6,
      'read'       => false,
  ))->
  end()->

  info('notify an event invite')->
  get('/event/1')->
  click('invite', array('sf_social_event_invite' => array(
    'user_id' => array(1, 5),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 1,
      'model_name' => 'sfSocialEventInvite',
      'model_id'   => 4,
      'read'       => false,
  ))->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 5,
      'model_name' => 'sfSocialEventInvite',
      'model_id'   => 5,
      'read'       => false,
  ))->
  end()->

  info('click on notify of message')->
  get('/')->
  click('message')->
  with('request')->begin()->
    isParameter('module', 'sfSocialNotify')->
    isParameter('action', 'get')->
  end()->
  with('response')->begin()->
    isRedirected()->
    followRedirect()->
  end()->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'read')->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 8,
      'model_name' => 'sfSocialMessage',
      'model_id'   => 3,
      'read'       => true,
  ))->
  end()->

  info('click on notify of request')->
  get('/')->
  click('contact request')->
  with('request')->begin()->
    isParameter('module', 'sfSocialNotify')->
    isParameter('action', 'get')->
  end()->
  with('response')->begin()->
    isRedirected()->
    followRedirect()->
  end()->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'requests')->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 8,
      'model_name' => 'sfSocialContactRequest',
      'model_id'   => 1,
      'read'       => true,
  ))->
  end()->

  info('click on notify of invite')->
  get('/')->
  click('invite to join group webgrrls')->
  with('request')->begin()->
    isParameter('module', 'sfSocialNotify')->
    isParameter('action', 'get')->
  end()->
  with('response')->begin()->
    isRedirected()->
    followRedirect()->
  end()->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'view')->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => 8,
      'model_name' => 'sfSocialGroupInvite',
      'model_id'   => 3,
      'read'       => true,
  ))->


end()
;