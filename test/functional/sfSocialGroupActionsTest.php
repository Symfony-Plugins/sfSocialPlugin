<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$browser->

  doLogin()->

  info('index (list)')->
  get('/groups/')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'list')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body h2', '/Groups/')->
    checkElement('ul#list li', 6)->
  end()->

  info('single group')->
  click('we are all dummies')->
    with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'view')->
  end()->
    with('response')->begin()->
    checkElement('body h2', '/Group "we are all dummies"/')->
  end()->

  info('edit a group')->
  click('Edit group')->
    with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'edit')->
  end()->
    with('response')->begin()->
    checkElement('body h2', '/Edit group "we are all dummies"/')->
  end()->
  click('edit', array('sf_social_group' => array(
    'title'       => '',
    'description' => '',
  )))->
  with('form')->begin()->hasErrors(2)->
    isError('title', 'required')->
    isError('description', 'required')->
  end()->
  click('edit', array('sf_social_group' => array(
    'title'       => 'We rulez',
    'description' => 'Now we are the masterers!',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialGroup', array(
      'title'       => 'We rulez',
      'description' => 'Now we are the masterers!',
  ))->
  end()->

  info('create a new group')->
  get('/group/create')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'create')->
  end()->
  click('create', array('sf_social_group' => array(
    'title'       => '',
    'description' => '',
  )))->
  with('form')->begin()->hasErrors(2)->
    isError('title', 'required')->
    isError('description', 'required')->
  end()->
  click('create', array('sf_social_group' => array(
    'title'       => 'A new group',
    'description' => 'What about a new group?',
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialGroup', array(
      'title'       => 'A new group',
      'description' => 'What about a new group?',
      'user_admin'  => 8,
  ))->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => 7,
      'user_id'  => 8,
  ))->
  end()->

  info('invite users to join group')->
  get('/group/1')->
  click('invite', array('sf_social_group_invite' => array(
    'user_id' => array(1, 2, 3),
  )))->
  with('form')->begin()->hasErrors(false)->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupInvite', array(
      'group_id' => 1,
      'replied'  => false,
  ), 4)->
  end()->

  info('join a group directly')->
  get('/group/6')->
  click('Join this group')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'join')->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => 6,
      'user_id'  => 8,
  ))->
  end()->

  info('join a group accepting an invite')->
  get('/group/4')->
  click('Accept invite')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'accept')->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => 4,
      'user_id'  => 8,
  ))->
  end()->

  info('refuse an invite')->
  get('/group/4/deny')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'deny')->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => 5,
      'user_id'  => 8,
  ), false)->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupInvite', array(
      'id' => 4,
      'replied'=> true,
  ))->
  end()->

  info('edit forbidden group')->
  get('/group/4/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()

;