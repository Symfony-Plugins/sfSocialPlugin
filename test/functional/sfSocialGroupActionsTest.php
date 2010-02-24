<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new loggedTest(new sfBrowser());

$browser->setTester('propel', 'sfTesterPropel');

$john = sfGuardUserPeer::retrieveByUsername('john');
$mike = sfGuardUserPeer::retrieveByUsername('mike');
$danny = sfGuardUserPeer::retrieveByUsername('danny');
$mario = sfGuardUserPeer::retrieveByUsername('mario');
$anna = sfGuardUserPeer::retrieveByUsername('anna');
$max = sfGuardUserPeer::retrieveByUsername('max');
$group1 = sfSocialGroupPeer::retrieveByTitle('we are all dummies');
$group4 = sfSocialGroupPeer::retrieveByTitle('webgrrls');
$group5 = sfSocialGroupPeer::retrieveByTitle('a group for web creatives');
$group6 = sfSocialGroupPeer::retrieveByTitle('mensa members');
$invite4 = sfSocialGroupInvitePeer::retrieveByInvite($group4, $max, $anna);

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
  with('form')->begin()->
    hasErrors(2)->
    isError('title', 'required')->
    isError('description', 'required')->
  end()->
  click('create', array('sf_social_group' => array(
    'title'       => 'A new group',
    'description' => 'What about a new group?',
  )))->
  with('form')->hasErrors(false)->
  with('propel')->begin()->
    check('sfSocialGroup', array(
      'title'       => 'A new group',
      'description' => 'What about a new group?',
      'user_admin'  => $max->getId(),
  ))->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => $group6->getId() + 1,
      'user_id'  => $max->getId(),
  ))->
  end()->

  info('invite users to join group')->
  get('/group/' . $group1->getId())->
  click('invite', array('sf_social_group_invite' => array(
    'user_id' => array($john->getId(), $mike->getId(), $danny->getId()),
  )))->
  with('form')->hasErrors(false)->
  with('propel')->begin()->
    check('sfSocialGroupInvite', array(
      'group_id' => $group1->getId(),
      'replied'  => false,
    ), 4)->
  end()->

  info('invite an user that already confirmed')->
  get('/group/' . $group1->getId())->
  click('invite', array('sf_social_group_invite' => array(
    'user_id' => $mario->getId(),
  )))->
  with('propel')->begin()->
    check('sfSocialGroupInvite', array(
      'group_id'  => $group1->getId(),
      'user_id'   => $mario->getId(),
      'user_from' => $max->getId(),
      'replied'   => false,
    ), false)->
  end()->

  info('join a group directly')->
  get('/group/' . $group6->getId())->
  click('Join this group')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'join')->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => $group6->getId(),
      'user_id'  => $max->getId(),
    ))->
  end()->

  info('join a group accepting an invite')->
  get('/group/' . $group4->getId())->
  click('Accept invite')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'accept')->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => $group4->getId(),
      'user_id'  => $max->getId(),
    ))->
  end()->

  info('refuse an invite')->
  get('/group/' . $group4->getId() . '/deny')->
  with('request')->begin()->
    isParameter('module', 'sfSocialGroup')->
    isParameter('action', 'deny')->
  end()->
  with('propel')->begin()->
    check('sfSocialGroupUser', array(
      'group_id' => $group5->getId(),
      'user_id'  => $max->getId(),
    ), false)->
    check('sfSocialGroupInvite', array(
      'id'      => $invite4->getId(),
      'replied' => true,
    ))->
  end()->

  info('edit forbidden group')->
  get('/group/' . $group4->getId() . '/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()

;