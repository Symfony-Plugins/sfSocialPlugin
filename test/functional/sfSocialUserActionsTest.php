<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$browser->

  doLogin()->

  info('user page')->
  get('/user/max')->
    with('request')->begin()->
    isParameter('module', 'sfSocialUser')->
    isParameter('action', 'user')->
  end()->
    with('response')->begin()->
    checkElement('body h2', '/max/')->
    checkElement('body', '/it\'s you!/')->
    checkElement('a[href$="user/max/edit"]', 'Edit profile')->
  end()->

  info('edit profile')->
  click('Edit profile')->
  click('edit', array('sf_guard_user' => array(
    'password'       => 'wrong',
    'password_again' => 'pass',
    'birthday'       => array('year' => 0),
    'sex'            => 'Z',
    'picture'        => dirname(__FILE__) . '/../fixtures/image_too_big.png',
  )))->
  with('form')->begin()->hasErrors(4)->
    isError('password', 'invalid')->
    isError('birthday', 'invalid')->
    isError('sex', 'invalid')->
    isError('picture', 'max_size')->
  end()->
  click('edit', array('sf_guard_user' => array(
    'first_name' => 'Massimiliano',
    'birthday'   => array('year' => 1974, 'month' => 4, 'day' => 1),
    'sex'        => 'M',
    'location'   => 'Rome',
    'picture'    => dirname(__FILE__) . '/../fixtures/image_ok.png',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfGuardUserProfile', array(
      'user_id'    => 8,
      'first_name' => 'Massimiliano',
      'birthday'   => '1974-04-01',
      'sex'        => 'M',
      'location'   => 'Rome',
      'picture'    => 'max.png',
  ))->
  end()->

  info('profile of one of your contacts')->
  get('/user/mario')->
    with('response')->begin()->
    checkElement('a[href$="/contacts"]', 'mario is your contact')->
    checkElement('a[href$="user/mario/edit"]', false)->
  end()->

  info('profile of someone you requested contact')->
  get('/user/luigi')->
    with('response')->begin()->
    checkElement('a[href$="contacts/sentrequests"]', 'A contact request is pending')->
  end()->

  info('profile of someone requested you contact')->
  get('/user/danny')->
    with('response')->begin()->
    checkElement('a[href$="contacts/requests"]', 'A contact request is pending')->
  end()->

  info('profile of someone else')->
  get('/user/goofy')->
    with('response')->begin()->
    checkElement('a[href$="/request/send/to/goofy"]', 'Add goofy to your contacts')->
  end()->

  info('edit profile of other user')->
  get('/user/danny/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()

;