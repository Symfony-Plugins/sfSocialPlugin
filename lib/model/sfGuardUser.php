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
class sfGuardUser extends PluginsfGuardUser
{
  protected $contacts	= null;
  
  /**
   * Returns true if user has contact.
   *
   * @param  sfGuardUser $user_to
   * @return boolean
   */
  public function hasContact($user_to)
  {
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $user_to->getId());
		$sc = sfSocialContactPeer::doSelectOne($c);
		if ($sc)
		{
	  	return true;
		}
		
		return false;
  }
  
  /**
   * Send request to contact.
   *
   * @param  sfGuardUser $user_to
   * @return boolean
   */  
  public function sendRequestContact(sfGuardUser $user_to, $message = '')
  {
    if ($user_to instanceof sfGuardUser)
		{
	  	$user_to = $user_to->getId();
		}

		$user_to = sfGuardUserPeer::retrieveByPk($user_to);
    if (!$user_to)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $user_to));
    }

		if ($user_to->getId() == $this->getId())
    {
      throw new Exception(sprintf("You can't add yourself as a contact", $user_to));
    }

   	if($this->hasContact($user_to))
  	{
			throw new Exception(sprintf("You can't add a contact that already exist", $user_to));
		}
		
		$scr = new sfSocialContactRequest();
  	$scr->setUserFrom($this->getId());
  	$scr->setUserTo($user_to->getId());
  	$scr->setMessage($message);
  	$scr->save();
  }
  
  /**
   * Accept request from contact.
   *
   * @param  sfGuardUser $user_to
   * @return boolean
   */  
  public function acceptRequestContact(sfSocialContactRequest $scr)
  {
    if($scr instanceof sfSocialContactRequest)
		{
	  	$scr = $scr->getId();
		}

		$scr = sfSocialContactRequest::retrieveByPk($scr);
    if (!$scr)
    {
      throw new Exception(sprintf('The request "%s" does not exist.', $scr));
    }
   	
   	// mark as accept
		$scr->accepted();
	
		// add contact
		$this->addContact($scr->getUserFrom());
  }
  
  /**
   * Refused request from contact.
   *
   * @param  sfGuardUser $user_to
   * @return boolean
   */  
  public function denyRequestContact(sfSocialContactRequest $scr)
  {
    if($scr instanceof sfSocialContactRequest)
		{
	  	$scr = $scr->getId();
		}

		$scr = sfSocialContactRequest::retrieveByPk($scr);
    if (!$scr)
    {
      throw new Exception(sprintf('The request "%s" does not exist.', $scr));
    }
   	
		$scr->refused();
  }
  
  /**
   * Returns an array containing the contacts list.
   *
   * @param  int $limit
   * @return array
   */	
  public function getContacts($limit = false)
  {
		if (!$this->contacts)
		{
	  	$c = new Criteria();
	  	$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
	  	if($limit)
	   		$c->setLimit($limit);
	  	$scs = sfSocialContactPeer::doSelect($c);
		
	  	foreach ($scs as $sc)
	  	{
	    	$this->contacts[] = $sc->getsfGuardUserRelatedByUserTo();
	  	}
		
	  	return  $this->contacts;
		}
  }
	
	/**
   * Add contact 
   *
   * @param  sfGuardUser $user_to
   * @return boolean
   */
	public function addContact($user_to)
  {
    if($user_to instanceof sfGuardUser)
		{
	  	$user_to = $user_to->getId();
		}

		$user_to = sfGuardUserPeer::retrieveByPk($user_to);
    if (!$user_to)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $user_to));
    }
    
		$sc = new sfSocialContact();
		$sc->setUserFrom($this->getId());
		$sc->setUserTo($user_to->getId());
		$sc->save();
		
		$sc = new sfSocialContact();
		$sc->setUserFrom($user_to->getId());
		$sc->setUserTo($this->getId());
		$sc->save();
  }
	
	/**
   * Remove contact 
   *
   * @param  sfGuardUser $user_to
   * @return boolean
   */
  public function removeContact($user_to)
  {
    if ($user_to instanceof sfGuardUser)
		{
	  	$user_to = $user_to->getId();
		}
		
    $user_to = sfGuardUserPeer::retrieveByUsername($user_to);
    if (!$user_to)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $user_to));
    }
    
    $c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $user_to->getId());
		return sfSocialContactPeer::doDelete($c);
  }
	
	/**
   * Add contact by username 
   *
   * @param  string $username
   * @return boolean
   */
  public function addContactbyUsername($username)
  {
		$user_to = sfGuardUserPeer::retrieveByUsername($username);
    if (!$user_to)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $user_to));
   	}
    
		$sc = new sfSocialContact();
		$sc->setUserFrom($this->getId());
		$sc->setUserTo($user_to->getId());
		$sc->save();
  }
	
	/**
   * Remove contact by username 
   *
   * @param  string $username
   * @return boolean
   */
  public function removeContactByUsername($username)
  {
    $user_to = sfGuardUserPeer::retrieveByUsername($username);
    if (!$user_to)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $user_to));
    }
    
		$this->removeContact($user_to);
  }
	
	/**
   * Remove all contatcs 
   *
   * @return boolean
   */	
  public function removeAllContacts()
  {
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		return sfSocialContactPeer::doDelete($c);
  }
}