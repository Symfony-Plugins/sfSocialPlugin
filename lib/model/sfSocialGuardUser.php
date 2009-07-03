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
class sfSocialGuardUser extends PluginsfGuardUser
{
  protected $contacts	= null;

  /**
   * Returns true if user has contact.
   * @param  sfGuardUser $userTo
   * @return boolean
   */
  public function hasContact($userTo)
  {
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $userTo->getId());
		$sc = sfSocialContactPeer::doSelectOne($c);
		if ($sc)
		{
	  	return true;
		}

		return false;
  }

  /**
   * Send request to contact.
   * @param  sfGuardUser $userTo
   * @return boolean
   */
  public function sendRequestContact(sfGuardUser $userTo, $message = '')
  {
		if ($userTo->getId() == $this->getId())
    {
      throw new Exception(sprintf('You can\'t add yourself as a contact', $userTo));
    }

   	if($this->hasContact($userTo))
  	{
			throw new Exception(sprintf('You can\'t add a contact that already exist', $userTo));
		}

		$scr = new sfSocialContactRequest();
  	$scr->setUserFrom($this->getId());
  	$scr->setUserTo($userTo->getId());
  	$scr->setMessage($message);
  	$scr->save();
  }

  /**
   * Accept request from contact.
   * @param  sfSocialContactRequest $scr
   */
  public function acceptRequestContact(sfSocialContactRequest $scr)
  {
		// add contact
		$this->addContact($scr->getUserFrom());

   	// mark as accept
		$scr->accepted();
  }

  /**
   * Refused request from contact.
   * @param  sfGuardUser $userTo
   * @return boolean
   */
  public function denyRequestContact(sfSocialContactRequest $scr)
  {
		$scr->refused();
  }

  /**
   * Returns an array containing the contacts list.
   * @param  integer $limit
   * @return array
   */
  public function getContacts($limit = 0)
  {
		if (!is_array($this->contacts))
		{
      $this->contacts = array();
	  	$c = new Criteria();
	  	$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
	  	if ($limit > 0)
      {
	   		$c->setLimit($limit);
      }
	  	$scs = sfSocialContactPeer::doSelect($c);
      if (!empty($scs))
      {
        foreach ($scs as $sc)
        {
          $this->contacts[] = $sc->getsfGuardUserRelatedByUserTo();
        }
      }
		}
    return $this->contacts;
  }

  /**
   * Get contact list, plus a sender user (if not already in contacts)
   * This is useful to reply to a message (see sfSocialMessageForm)
   * @param  integer $senderId
   * @return array
   */
  public function getContactsAndSender($senderId)
  {
    $contacts = $this->getContacts();
    $sender = sfGuardUserPeer::retrieveByPK($senderId);
    if (empty($sender) || in_array($sender, $contacts))
    {
      return $contacts;
    }
    $contacts[] = $sender;
    return $contacts;
  }

	/**
   * Add contact
   * @param sfGuardUser $userTo
   */
	public function addContact(sfGuardUser $userTo)
  {
		$sc = new sfSocialContact();
		$sc->setUserFrom($this->getId());
		$sc->setUserTo($userTo->getId());
		$sc->save();
		$sc = new sfSocialContact();
		$sc->setUserFrom($userTo->getId());
		$sc->setUserTo($this->getId());
		$sc->save();
  }

	/**
   * Remove contact
   * @param sfGuardUser $userTo
   */
  public function removeContact(sfGuardUser $userTo)
  {
    $c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $userTo->getId());
		sfSocialContactPeer::doDelete($c);
    $c = new Criteria();
		$c->add(sfSocialContactPeer::USER_TO, $this->getId());
		$c->add(sfSocialContactPeer::USER_FROM, $userTo->getId());
		sfSocialContactPeer::doDelete($c);
  }

	/**
   * Add contact by username
   * @param string $username
   */
  public function addContactbyUsername($username)
  {
		$userTo = sfGuardUserPeer::retrieveByUsername($username);
    if (!$userTo)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $userTo));
   	}
    $this->addContact($userTo);
  }

	/**
   * Remove contact by username
   *
   * @param  string  $username
   * @return boolean
   */
  public function removeContactByUsername($username)
  {
    $userTo = sfGuardUserPeer::retrieveByUsername($username);
    if (!$userTo)
    {
      throw new Exception(sprintf('The user "%s" does not exist.', $userTo));
    }
		$this->removeContact($userTo);
  }

	/**
   * Remove all contatcs
   */
  public function removeAllContacts()
  {
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		sfSocialContactPeer::doDelete($c);
    $c = new Criteria();
		$c->add(sfSocialContactPeer::USER_TO, $this->getId());
		sfSocialContactPeer::doDelete($c);
  }
}