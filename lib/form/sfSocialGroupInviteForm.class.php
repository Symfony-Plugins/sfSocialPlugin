<?php

/**
 * sfSocialGroupInvite form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialGroupInviteForm extends BasesfSocialGroupInviteForm
{
  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at'], $this['replied']);

    // make user_from hidden
    $this->widgetSchema['user_from'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_from', $this->options['user']->getId());
    $this->setValidator('user_from', new sfValidatorChoice(array('choices' => array($this->options['user']->getId()))));

    // make group_id hidden
    $this->widgetSchema['group_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('group_id', $this->options['group']->getId());
    $this->setValidator('group_id', new sfValidatorChoice(array('choices' => array($this->options['group']->getId()))));

    // restrict users to invite to user's friends
    $c = new Criteria;
    $c->add(sfSocialContactPeer::USER_FROM, $this->options['user']->getId())->
      setLimit(50)->
      addAscendingOrderByColumn(sfGuardUserPeer::USERNAME);
    $this->widgetSchema['user_id']->setOption('model', 'sfSocialContact');
    $this->widgetSchema['user_id']->addOption('multiple', true);
    $this->widgetSchema['user_id']->addOption('peer_method', 'doSelectJoinsfGuardUserRelatedByUserTo');
    $this->widgetSchema['user_id']->addOption('criteria', $c);
    $this->widgetSchema['user_id']->addOption('key_method', 'getUserId');
    $this->validatorSchema['user_id']->addOption('multiple', true);
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback'  => array($this, 'unique_check')))
    );
  }

  /**
   * callback to clean possible duplicate values on user_id (if multiple submitted),
   * without invalidating the entire form
   * @param  sfValidatorCallback $validator
   * @param  array               $values    form's values
   * @param  array               $arguments unused in this case
   * @return array
   */
  public function unique_check($validator, $values, $arguments)
  {
    if (is_array($values['user_id']))
    {
      foreach ($values['user_id'] as $k => $user_id)
      {
        $c = new Criteria;
        $c->add(sfSocialGroupInvitePeer::GROUP_ID, $values['group_id']);
        $c->add(sfSocialGroupInvitePeer::USER_FROM, $values['user_from']);
        $c->add(sfSocialGroupInvitePeer::USER_ID, $user_id);
        $invite = sfSocialGroupInvitePeer::doSelectOne($c);
        if (null !== $invite)
        {
          unset($values['user_id'][$k]);
        }
      }
      return $values;
    }
    else
    {
      $validator = new sfValidatorPropelUnique(array('model' => 'sfSocialGroupInvite', 'column' => array('Group_id', 'user_id', 'user_from')));
      return $validator->clean($values);
    }
  }

  /**
   * ovveride to save many invites instead of just one
   * @param PropelPDO $con
   */
  public function doSave($con = null)
  {
    if (is_null($con))
    {
      $con = $this->getConnection();
    }
    $this->updateObject();
    $values = $this->getValues();
    if (is_array($values['user_id']))
    {
      foreach ($values['user_id'] as $user_id)
      {
        $obj = clone $this->getObject();
        $obj->setUserId($user_id);
        $obj->save();
      }
    }
    else
    {
      parent::doSave($con);
    }
  }

}
