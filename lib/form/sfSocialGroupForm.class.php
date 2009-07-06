<?php

/**
 * sfSocialGroup form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialGroupForm extends BasesfSocialGroupForm
{
  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at'], $this['updated_at'], $this['sf_social_group_user_list']);

    // hide user_admin, binding it to current user's id
    $this->widgetSchema['user_admin'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_admin', $this->options['user']->getId());
    $this->setValidator('user_admin', new sfValidatorChoice(array('choices' => array($this->options['user']->getId()))));
  }

  /**
   * ovveride to automatically make group's creator also a group member
   * @param PropelPDO $con
   */
  public function doSave($con = null)
  {
    if (!$this->getObject()->isNew())
    {
      parent::doSave($con);
    }
    else
    {
      try
      {
        $con->beginTransaction();
        parent::doSave($con);
        $groupUser = new sfSocialGroupUser;
        $groupUser->setsfSocialGroup($this->getObject());
        $groupUser->setUserId($this->getValue('user_admin'));
        $groupUser->save();
        $con->commit();
      }
      catch (Exception $e)
      {
        $con->rollBack();
        throw $e;
      }
    }
  }

}
