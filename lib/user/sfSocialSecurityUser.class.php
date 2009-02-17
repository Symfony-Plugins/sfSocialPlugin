<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Lionel Guichard <lionel.guichard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Lionel Guichard <lionel.guichard@gmail.com>
 */
class sfSocialSecurityUser extends sfGuardSecurityUser
{
  /**
   * Check is user is friend
   * 
   * @param  sfGuardUser $user
   * @return boolean 
   * @access public
   */
  public function hasContact($user)
  {
    return $this->getGuardUser() ? $this->getGuardUser()->hasContact($user) : false;
  }
	
  /**
   * Get array with list of contacts 
   * 
   * @param  int $limit
   * @return array 
   * @access public
	 */
  public function getContacts($limit = false)
  {
    return $this->getGuardUser() ? $this->getGuardUser()->getContacts() : false;
  }

  /**
   * Adding a contact
   * 
   * @param  sfGuardUser $user
   * @return booelan 
   * @access public
   */
  public function addContact($user)
  {
    return $this->getGuardUser()->addContact($user);
  }
	
  /**
   * Accept request from a contact
   * 
   * @param  sfGuardUser $user
   * @param  string $message
   * @return booelan 
   * @access public
   */
  public function sendRequestContact($user, $message = '')
  {
    return $this->getGuardUser()->sendRequestContact($user, $message);
  }
	
  /**
   * Accept request from a contact
   * 
   * @param  user $user
   * @return booelan 
   * @access public
   */
  public function acceptRequestContact($user)
  {
    return $this->getGuardUser()->acceptRequestContact($user);
  }

  /**
   * Deny request from a contact
   * 
   * @param  user $user
   * @return booelan 
   * @access public
   */
  public function denyRequestContact($user)
  {
    return $this->getGuardUser()->denyRequestContact($user);
  }
	
  /**
   * Remove contact
   * 
   * @param  user $user
   * @return boolean 
   * @access public
   */
  public function removeContact($user)
  {
  	return $this->getGuardUser()->removeContact($user);
  }
	
  /**
   * Adding a contact from username
   * 
   * @param  string $username
   * @return booelan 
   * @access public
   */
  public function addContactByUsername($username)
  {
    return $this->getGuardUser()->addContactByUsername($username);
  }
	
  /**
   * Remove contact from username
   * 
   * @param  string $username
   * @return boolean 
   * @access public
   */
  public function removeContactByUsername($username)
  {
  	return $this->getGuardUser()->removeContactByUsername($username);
  }
	
  /**
   * Remove all contatcs from username
   * 
   * @param  null
   * @return boolean 
   * @access public
   */
  public function removeAllContacts()
  {
  	return $this->getGuardUser()->removeAllContacts();
  }
}