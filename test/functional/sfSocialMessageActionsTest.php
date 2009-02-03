<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  info('index (list)')->
  get('/messages/')->

  with('request')->begin()->
    isParameter('module', 'sfSocialMessage')->
    isParameter('action', 'list')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body h2', '/messages/')->
    checkElement('body ul li', 2)->
  end()
;