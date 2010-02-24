<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$john = sfGuardUserPeer::retrieveByUsername('john');
$mike = sfGuardUserPeer::retrieveByUsername('mike');
$luigi = sfGuardUserPeer::retrieveByUsername('luigi');
$max = sfGuardUserPeer::retrieveByUsername('max');
$event1 = sfSocialEventPeer::retrieveByTitle('let\'s party!');
$group1 = sfSocialGroupPeer::retrieveByTitle('we are all dummies');

$c = new Criteria;
$c->addDescendingOrderByColumn(sfSocialMessagePeer::ID);
$lastMessage = sfSocialMessagePeer::doSelectOne($c);

$c = new Criteria;
$c->addDescendingOrderByColumn(sfSocialContactRequestPeer::ID);
$lastContactRequest = sfSocialContactRequestPeer::doSelectOne($c);

$c = new Criteria;
$c->addDescendingOrderByColumn(sfSocialEventInvitePeer::ID);
$lastEventInvite = sfSocialEventInvitePeer::doSelectOne($c);

$c = new Criteria;
$c->addDescendingOrderByColumn(sfSocialGroupInvitePeer::ID);
$lastGroupInvite = sfSocialGroupInvitePeer::doSelectOne($c);

$browser->

  doLogin()->

  info('notify a new message')->
  get('/message/compose')->
  click('send', array('sf_social_message' => array(
    'subject' => 'hello',
    'text'    => 'just a test',
    'to'      => array($john->getId(), $mike->getId()),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $john->getId(),
      'model_name' => 'sfSocialMessage',
      'model_id'   => $lastMessage->getId() + 1,
      'is_read'    => false,
    ))->
    check('sfSocialNotify', array(
      'user_id'    => $mike->getId(),
      'model_name' => 'sfSocialMessage',
      'model_id'   => $lastMessage->getId() + 1,
      'is_read'    => false,
  ))->
  end()->

  info('notify a contact request')->
  get('/request/send')->
  click('send', array('sf_social_contact_request' => array(
    'user_to' => $john->getId(),
    'message' => 'just a test'
  )))->
  with('form')->hasErrors(false)->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $john->getId(),
      'model_name' => 'sfSocialContactRequest',
      'model_id'   => $lastContactRequest->getId() + 1,
      'is_read'    => false,
    ))->
  end()->

  info('notify a group invite ' . $lastGroupInvite->getId())->
  get('/group/' . $group1->getId())->
  click('invite', array('sf_social_group_invite' => array(
    'user_id' => array($john->getId(), $mike->getId()),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $john->getId(),
      'model_name' => 'sfSocialGroupInvite',
      'model_id'   => $lastGroupInvite->getId() + 1,
      'is_read'    => false,
    ))->
    check('sfSocialNotify', array(
      'user_id'    => $mike->getId(),
      'model_name' => 'sfSocialGroupInvite',
      'model_id'   => $lastGroupInvite->getId() + 2,
      'is_read'    => false,
    ))->
  end()->

  info('notify an event invite')->
  get('/event/' . $event1->getId())->
  click('invite', array('sf_social_event_invite' => array(
    'user_id' => array($john->getId(), $luigi->getId()),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $john->getId(),
      'model_name' => 'sfSocialEventInvite',
      'model_id'   => $lastEventInvite->getId() + 1,
      'is_read'    => false,
    ))->
    check('sfSocialNotify', array(
      'user_id'    => $luigi->getId(),
      'model_name' => 'sfSocialEventInvite',
      'model_id'   => $lastEventInvite->getId() + 2,
      'is_read'    => false,
  ))->
  end()->

  info('click on notify of message')->
  get('/')->
  click('message')->
  with('request')->begin()->
    isParameter('module', 'sfSocialNotify')->
    isParameter('action', 'get')->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'read')->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $max->getId(),
      'model_name' => 'sfSocialMessage',
      'is_read'    => true,
    ))->
  end()->

  info('click on notify of contact request')->
  get('/')->
  click('contact request')->
  with('request')->begin()->
    isParameter('module', 'sfSocialNotify')->
    isParameter('action', 'get')->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('request')->begin()->
    isParameter('module', 'sfSocialContact')->
    isParameter('action', 'requests')->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $max->getId(),
      'model_name' => 'sfSocialContactRequest',
      'is_read'    => true,
    ))->
  end()->

  info('click on notify of group invite')->
  get('/')->
  click('invite to join group webgrrls')->
  with('request')->begin()->
    isParameter('module', 'sfSocialNotify')->
    isParameter('action', 'get')->
  end()->
  with('response')->isRedirected()->followRedirect()->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'view')->
  end()->
  with('propel')->begin()->
    check('sfSocialNotify', array(
      'user_id'    => $max->getId(),
      'model_name' => 'sfSocialGroupInvite',
      #'model_id'   => 3,
      'is_read'    => true,
    ))->

end()
;