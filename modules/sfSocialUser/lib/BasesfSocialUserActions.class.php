<?php

/**
 * Base actions for the sfSocialPlugin sfSocialUser module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialUser
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
abstract class BasesfSocialUserActions extends sfActions
{

 /**
  * User's page
  * @param sfRequest $request A request object
  */
  public function executeUser(sfWebRequest $request)
  {
    $username = $request->getParameter('username');
    $this->user = sfGuardUserPeer::retrieveByUsername($username);
    $this->forward404Unless($this->user, 'user not found');
  }

}
