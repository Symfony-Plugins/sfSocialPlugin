<?php

include dirname(__FILE__) . '/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

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
    #checkElement('ul#list li[class*="unread"]', true, array('position' => 2))->
  end();

$browser->test()->is($browser->getResponseDom()->getElementsByTagName('li')->item(3)->getAttribute('class'), ' unread', 'message is unread');

$browser->

  info('click on a message')->
  click('hello pal')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'read')->
  end()->
  with('response')->begin()->
    checkElement('body h2', '/hello pal/')->
  end()->
  click('Back to list')
;

$browser->test()->is($browser->getResponseDom()->getElementsByTagName('li')->item(3)->getAttribute('class'), ' read', 'message is now read');

$browser->

  info('compose a new message')->
  click('Compose a new message')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'compose')->
  end()->
  with('response')->begin()->
    checkElement('body h2', '/Compose a new message/')->
  end()->
  click('send', array('sf_social_message' => array(
    'subject' => '',
    'text'    => '',
    'to'      => array(),
  )))->
  with('form')->begin()->hasErrors(3)->
    isError('subject', 'required')->
    isError('text', 'required')->
    isError('to', 'required')->
  end()->
  click('send', array('sf_social_message' => array(
    'subject' => 'a message from functional test',
    'text'    => 'TDD rulez! I found a lot of bugs doing these nice tests.',
    'to'      => array(4, 10),
  )))->
  # TODO!
  #with('form')->begin()->hasErrors(false)->
  #with('form')->debug()->

  info('sent messages')->
  get('/messages/sent')->
  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'sentlist')->

  end()
;