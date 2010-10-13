<?php

/**
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialGuardUser
 * @author     Lionel Guichard <lionel.guichard@gmail.com>
 */
class PluginsfSocialGuardUser extends PluginsfGuardUser
{
  protected $contacts	= null;

  /**
   * Check if user has contact.
   * @param  sfGuardUser $userTo
   * @return boolean
   */
  public function hasContact(sfGuardUser $userTo)
  {
		$c = new Criteria();
		$c->add(sfSocialContactPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactPeer::USER_TO, $userTo->getId());

    return sfSocialContactPeer::doCount($c) == 1;
  }

  /**
   * Check if user has a contact request.
   * @param  sfGuardUser $userTo
   * @return boolean
   */
  public function hasContactRequest(sfGuardUser $userTo)
  {
		$c = new Criteria();
		$c->add(sfSocialContactRequestPeer::USER_FROM, $this->getId());
		$c->add(sfSocialContactRequestPeer::USER_TO, $userTo->getId());

		return sfSocialContactRequestPeer::doCount($c) == 1;
  }

  /**
   * Send request to contact.
   * @param  sfGuardUser $userTo
   * @param  string      $message
   * @return boolean
   */
  public function sendRequestContact(sfGuardUser $userTo, $message = '')
  {
		if ($userTo->getId() == $this->getId())
    {
      throw new Exception(sprintf('You can\'t add yourself as a contact', $userTo));
    }

   	if ($this->hasContact($userTo))
  	{
			throw new Exception(sprintf('You can\'t add a contact that already exist', $userTo));
		}

		$contactRequest = new sfSocialContactRequest();
  	$contactRequest->setUserFrom($this->getId());
  	$contactRequest->setUserTo($userTo->getId());
  	$contactRequest->setMessage($message);
  	$contactRequest->save();
  }

  /**
   * Accept request from contact.
   * @param sfSocialContactRequest $scr
   */
  public function acceptRequestContact(sfSocialContactRequest $contactRequest)
  {
		// add contact
		$this->addContact($contactRequest->getUserFrom());

   	// mark as accept
		$contactRequest->accepted();
  }

  /**
   * Refuse request from contact.
   * @param  sfGuardUser $userTo
   * @return boolean
   */
  public function denyRequestContact(sfSocialContactRequest $contactRequest)
  {
		$contactRequest->refused();
  }

  /**
   * Number of contacts.
   * @return integer
   */
  public function countContacts()
  {
    return $this->countContactFroms();
  }

  /**
   * Returns contacts list.
   * @param  integer $limit
   * @return array
   */
  public function getContacts($limit = 0)
  {
		if (!is_array($this->contacts))
		{
      $this->contacts = array();
	  	$c = new Criteria();
	  	if ($limit > 0)
      {
	   		$c->setLimit($limit);
      }
	  	$contacts = $this->getContactFroms($c);
      if (!empty($contacts))
      {
        foreach ($contacts as $contact)
        {
          $this->contacts[] = $contact->getTo();
        }
      }
		}
    return $this->contacts;
  }

  /**
   * Returns a pager of contacts.
   * @param  integer $page current page
   * @return sfPager
   */
  public function getContactsPager($page = 1)
  {
    return sfSocialContactPeer::getContacts($this, $page);
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
		$contact = new sfSocialContact();
		$contact->setUserFrom($this->getId());
		$contact->setUserTo($userTo->getId());
		$contact->save();
		$contact = new sfSocialContact();
		$contact->setUserFrom($userTo->getId());
		$contact->setUserTo($this->getId());
		$contact->save();
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

	/**
   * Get thumbnail picture path
   * @return string
   */
  public function getThumb()
  {
    $path = sfConfig::get('app_sf_social_pic_path', '/sf_social_pics/');
    $pic = $this->getProfile()->getPicture();
    if (empty($pic))
    {
      return sfConfig::get('app_sf_social_default_pic', '/sfSocialPlugin/images/default.jpg');;
    }
    else
    {
      $upload = substr(sfConfig::get('sf_upload_dir'), strlen(sfConfig::get('sf_web_dir')));
      return  $upload . $path . 'thumbnails/' . $pic;
    }
  }

  /**
   * Get contacts shared with an user
   * @param  sfGuardUser $user
   * @param  integer     $limit
   * @return array             sfGuardUser objects
   */
  public function getSharedContacts(sfGuardUser $user, $limit = 0)
  {
    return sfSocialContactPeer::getSharedContacts($this, $user, $limit);
  }

  /**
   * Number of shared contacts with an user
   * @return integer
   */
  public function countSharedContacts(sfGuardUser $user)
  {
    return sfSocialContactPeer::countSharedContacts($this, $user);
  }

  /**
   * Get notifies (only unread ones)
   * @return array
   */
  public function getNotifies()
  {
    $c = new Criteria;
    $c->add(sfSocialNotifyPeer::IS_READ, false);

    return $this->getsfSocialNotifys($c);
  }

  /**
   * get ids of contacts
   * @return array
   */
  public function getContactIds()
  {
    return sfSocialContactPeer::getContactIds($this);
  }

  /**
   * @return array
   */
  public function getSocialGroups()
  {
    return $this->getsfSocialGroups();
  }

}
