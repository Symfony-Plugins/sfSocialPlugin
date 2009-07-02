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
    checkElement('body ul li', 7)->
  end()
;