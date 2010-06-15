<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$john = sfGuardUserPeer::retrieveByUsername('john');
$danny = sfGuardUserPeer::retrieveByUsername('danny');
$anna = sfGuardUserPeer::retrieveByUsername('anna');
$julie = sfGuardUserPeer::retrieveByUsername('julie');
$max = sfGuardUserPeer::retrieveByUsername('max');
$contact1 = sfSocialContactPeer::retrieveByUsers($anna, $julie);
$request1 = sfSocialContactRequestPeer::retrieveByUsers($danny, $max);
$request4 = sfSocialContactRequestPeer::retrieveByUsers($john, $anna);

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
  click('Remove', array('position' => 2), array('method' => 'delete', '_with_csrf' => true))->
  with('response')->isRedirected()->followRedirect()->
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
    'user_to' => $anna->getId(),
    'message' => 'can I be you friend?'
  )))->
  with('form')->hasErrors(false)->
  with('propel')->begin()->
    check('sfSocialContactRequest', array(
      'user_from' => $max->getId(),
      'user_to'   => $anna->getId(),
      'accepted'  => false,
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
      'user_from' => $john->getId(),
      'user_to'   => $max->getId(),
      'accepted'  => true,
    ))->
    check('sfSocialContact', array(
      'user_from' => $max->getId(),
      'user_to'   => $john->getId(),
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
      'user_from' => $danny->getId(),
      'user_to'   => $max->getId(),
    ), false)->
    check('sfSocialContact', array(
      'user_from' => $max->getId(),
      'user_to'   => $danny->getId(),
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
      'user_from' => $max->getId(),
      'user_to'   => $anna->getId(),
    ), false)->
  end()->

  info('unauthorized contact removing')->
  get('/contact/delete/' . $contact1->getId(), array(), array('method' => 'delete', '_with_csrf' => true))->
  with('response')->begin()->
    isStatusCode(404)->
  end()->

  info('unauthorized request accepting')->
  get('/request/accept/' .  $request4->getId())->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('unauthorized request denying')->
  get('/request/deny/' . $request4->getId())->
  with('response')->begin()->
    isStatusCode(403)->

  end()
;