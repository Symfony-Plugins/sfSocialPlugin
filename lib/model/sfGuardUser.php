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
	protected
    	$contacts	= null;

	public function hasFriend($user_to)
	{
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $user_to->getId());
		$sc = sfSocialContactPeer::doSelectOne($c);
		if($sc)
		{
			return true;
		}
		
		return false;
	}
	
	public function getContacts($limit = false)
	{
		if(!$this->contacts)
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
	
	public function removeContactByUsername($username)
	{
    	$user_to = sfGuardUserPeer::retrieveByUsername($username);
    	if (!$user_to)
    	{
      		throw new Exception(sprintf('The user "%s" does not exist.', $user_to));
    	}
    	
    	$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $user_to->getId());
		$sc = sfSocialContactPeer::doSelectOne($c);
		$sc->delete();
	}
	
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
	}
	
	public function removeContact($user_to)
	{
		if($user_to instanceof sfGuardUser)
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
		$sc = sfSocialContactPeer::doSelectOne($c);
		$sc->delete();
	}
	
	public function removeAllContacts()
	{
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$sc = sfSocialContactPeer::doDelete($c);
	}
}