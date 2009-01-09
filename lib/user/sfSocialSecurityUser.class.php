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
    * 
    * @param object $user_to
    * @return boolean 
    * @access public
    */
    public function hasFriend($user_to)
    {
		return $this->getGuardUser() ? $this->getGuardUser()->hasFriend($user_to) : false;
	}
	
	/**
    * Gets array with list of contacts 
    * 
    * @param int $limit
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
    * @param user $user_to
    * @return booelan 
    * @access public
    */
    public function addContact($user_to)
    {
		return $this->getGuardUser()->addContact($user_to);
	}
	
	/**
    * Remove contact
    * 
    * @param int $id
    * @return boolean 
    * @access public
    */
    public function removeContact($user_to)
    {
    	return $this->getGuardUser()->removeContact($user_to);
	}
	
	/**
    * Adding a contact from username
    * 
    * @param string $username
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
    * @param string $username
    * @return boolean 
    * @access public
    */
    public function removeContactByUsername($username)
    {
    	return $this->getGuardUser()->removeContactByUsername($username);
	}
	
	/**
    * Remove contact from username
    * 
    * @param null
    * @return boolean 
    * @access public
    */
    public function removeAllContacts()
    {
    	return $this->getGuardUser()->removeAllContacts();
	}
}