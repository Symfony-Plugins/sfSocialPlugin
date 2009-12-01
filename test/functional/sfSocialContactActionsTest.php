<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$browser->

  doLogin()->

  info('index (list)')->
  get('/contacts/')->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'list')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body h2', '/Contacts list/')->
    checkElement('ul#list li', 5)->
  end()->

  info('remove a contact')->
  click('Remove', array('position' => 2))->
  followRedirect()->
  with('response')->begin()->
    checkElement('ul#list li', 4)->
  end()->

  info('send a request')->
  click('Send request')->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'sendrequest')->
  end()->
  click('send', array('sf_social_contact_request' => array(
    'user_to' => 6,
    'message' => 'can I be you friend?'
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialContactRequest', array(
      'user_from' => 8,
      'user_to'   => 6,
      'accepted'  => 0,
  ))->
  end()->

  info('list of received requests')->
  get('/contacts/requests')->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'requests')->
  end()->

  info('accept a request')->
  click('Accept', array('position' => 1))->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'acceptrequest')->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('propel')->begin()->
    check('sfSocialContactRequest', array(
      'user_from' => 1,
      'user_to'   => 8,
      'accepted'  => 1,
  ))->
  end()->
  with('propel')->begin()->
    check('sfSocialContact', array(
      'user_from' => 8,
      'user_to'   => 1,
  ))->
  end()->

  info('deny a request')->
  click('Deny')->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'denyrequest')->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('propel')->begin()->
    check('sfSocialContactRequest', array(
      'user_from' => 3,
      'user_to'   => 8,
  ), false)->
  end()->
  with('propel')->begin()->
    check('sfSocialContact', array(
      'user_from' => 8,
      'user_to'   => 3,
  ), false)->
  end()->

  info('list of sent requests')->
  get('/contacts/sentrequests')->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'sentrequests')->
  end()->

  info('cancel a request')->
  click('cancel', array('position' => 1))->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'cancelrequest')->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('propel')->begin()->
    check('sfSocialContactRequest', array(
      'user_from' => 8,
      'user_to'   => 6,
  ), false)->
  end()->

  info('unauthorized contact removing')->
  get('/contact/delete/1')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('unauthorized request accepting')->
  get('/request/accept/4')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('unauthorized request denying')->
  get('/request/deny/4')->
  with('response')->begin()->
    isStatusCode(403)->

  end()
;