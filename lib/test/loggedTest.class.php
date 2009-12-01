<?php

/**
 * class to use login in functional tests
 * @author Massimiliano Arione
 */

class loggedTest extends sfTestFunctional
{
  /**
   * does login
   * @param  string     $username
   * @param  string     $password
   * @return LoggedTest
   */
  public function doLogin($username = 'max', $password = 'garak')
  {
    return $this->
      info('login')->
      get('/messages')->

      with('request')->begin()->
        isParameter('module', 'sfSocialMessage')->
        isParameter('action', 'list')->
      end()->

      with('response')->begin()->
        isStatusCode(401)->
      end()->

      click('sign in', array('signin' => array(
        'username' => $username,
        'password' => $password,
        )))->
      with('request')->begin()->
        isParameter('module', 'sfGuardAuth')->
        isParameter('action', 'signin')->
      end()->

      with('response')->isRedirected()->followRedirect()->
      with('response')->begin()->
        isStatusCode(200)->
      end();
  }
}
