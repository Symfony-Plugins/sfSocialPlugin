<?php

include dirname(__FILE__) . '/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$john = sfGuardUserPeer::retrieveByUsername('john');
$mike = sfGuardUserPeer::retrieveByUsername('mike');
$danny = sfGuardUserPeer::retrieveByUsername('danny');
$anna = sfGuardUserPeer::retrieveByUsername('anna');
$max = sfGuardUserPeer::retrieveByUsername('max');

$c = new Criteria;
$c->addDescendingOrderByColumn(sfSocialMessagePeer::CREATED_AT);
$lastMessage = sfSocialMessagePeer::doSelectOne($c);

$browser->

  doLogin()->

  info('index (list)')->
  get('/messages/')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'list')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body h2', '/Messages received/')->
    checkElement('ul#list li', 5)->
    checkElement('ul#list li.unread', true, array('position' => 2))->
    checkElement('ul#list li.unread', 4)->
    isValid(true)->
  end()->

  info('click on a message')->
  click('hello pal')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'read')->
  end()->
  with('response')->begin()->
    checkElement('body h2', '/hello pal/')->
    isValid(true)->
  end()->

  info('reply to message')->
  click('Reply')->
  with('response')->begin()->
    checkElement('input[name="sf_social_message[subject]"][value="Re: hello pal"]', true)->
    checkElement('select#sf_social_message_to > option[value="' . $danny->getId() . '"][selected="selected"]', true)->
  end()->
  click('cancel')->
  with('response')->begin()->
    checkElement('ul#list li.read', true, array('position' => 2))->
    isValid(true)->
  end()->

  info('compose a new message')->
  click('Compose a new message')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'compose')->
  end()->
  with('response')->begin()->
    checkElement('body h2', '/Compose a new message/')->
    isValid(true)->
  end()->
  click('send', array('sf_social_message' => array(
    'subject' => '',
    'text'    => '',
    'to'      => array(),
  )))->
  with('form')->begin()->
    hasErrors(3)->
    isError('subject', 'required')->
    isError('text', 'required')->
    isError('to', 'required')->
  end()->
  click('send', array('sf_social_message' => array(
    'subject' => 'a message from functional test',
    'text'    => 'TDD rulez! I found a lot of bugs doing these nice tests.',
    'to'      => array($john->getId(), $mike->getId()),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialMessage', array(
      'user_from' => $max->getId(),
      'subject'   => 'a message from functional test',
      'text'      => 'TDD rulez! I found a lot of bugs doing these nice tests.',
    ))->
    check('sfSocialMessageRcpt', array(
      'msg_id'  => $lastMessage->getId() + 1,
      'user_to' => $john->getId(),
      'is_read' => false,
    ))->
    check('sfSocialMessageRcpt', array(
      'msg_id'  => $lastMessage->getId() + 1,
      'user_to' => $mike->getId(),
      'is_read' => false,
    ))->
  end()->

  info('compose a message for a specific recipient')->
  get('/message/compose/to/anna')->
  with('response')->begin()->
    checkElement('select#sf_social_message_to > option[value="' . $anna->getId() . '"][selected="selected"]', true)->
    isValid(true)->
  end()->

  info('sent messages')->
  get('/messages/sent')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'sentlist')->
  end()->

  info('first message is now read')->
  get('/messages/')->
  with('response')->begin()->
    checkElement('ul#list li.unread', 3)->
  end()
;
