<?php

/**
 * sfSocialGroup
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialContact
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class PluginsfSocialContact extends BasesfSocialContact
{

  /**
   * magic method
   * @return string
   */
  public function __toString()
  {
    return $this->getTo();
  }

  /**
   * check if contact is belonging to user
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserFrom(sfGuardUser $user)
  {
		return $this->getUserFrom() == $user->getId();
  }

  /**
   * Override delete method for deleting mutual contacts
   * @param PropelPDO $con
   */
  public function delete(PropelPDO $con = null)
  {
		if ($con == null)
		{
      $con = Propel::getConnection();
		}
		try
		{
			$con->beginTransaction();
			parent::delete($con);
			$c = new Criteria();
			$c->add(sfSocialContactPeer::USER_FROM, $this->getUserTo());
			$c->add(sfSocialContactPeer::USER_TO, $this->getUserFrom());
			$contacts = sfSocialContactPeer::doSelect($c);
      foreach ($contacts as $contact)
      {
        $contact->delete();
      }
			$con->commit();
		}
		catch (PDOException $e)
		{
			$con->rollback();
			throw $e;
		}
  }

  /**
   * used by sfSocialMessageForm to get correct user's id
   * If not used, contact's id is taken instead (which is, of course, wrong)
   * @return integer
   */
  public function getUserId()
  {
    return $this->getTo()->getId();
  }

}
