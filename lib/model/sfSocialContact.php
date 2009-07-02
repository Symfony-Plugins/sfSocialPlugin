<?php

class sfSocialContact extends BasesfSocialContact
{

  /**
   * magic method
   * @return string
   */
  public function __toString()
  {
    return $this->getsfGuardUserRelatedByUserTo();
  }

  /**
   * check if contact is belonging to user
   *
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function checkUserFrom($user)
  {
		return $this->getUserTo() == $user->getId();
  }

  /**
   * Override delete method for delete mutual contacts
   *
   * @param  PropelPDO $con
   * @return boolean
   */
  public function delete(PropelPDO $con = null)
  {
		if ($this->isDeleted())
  	{
	  	throw new PropelException("You cannot delete an object that has been deleted.");
    }

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
			sfSocialContactPeer::doDelete($c);

			$c = new Criteria();
			$criterion = $c->getNewCriterion(sfSocialContactRequestPeer::USER_FROM, $this->getUserTo())->addOr($c->getNewCriterion(sfSocialContactRequestPeer::USER_TO, $this->getUserTo()));
			$c->addAnd($criterion);
			$criterion = $c->getNewCriterion(sfSocialContactRequestPeer::USER_FROM, $this->getUserFrom())->addOr($c->getNewCriterion(sfSocialContactRequestPeer::USER_TO, $this->getUserFrom()));
			$c->addAnd($criterion);
			sfSocialContactRequestPeer::doDelete($c);

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
    return $this->getsfGuardUserRelatedByUserTo()->getId();
  }

}
