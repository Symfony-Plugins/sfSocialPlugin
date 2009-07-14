<?php

/**
 * sfSocialEventUser form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialEventUserForm extends BasesfSocialEventUserForm
{

  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at']);

    // make confirm a choice (i18n solution is very ugly, is there a better way? TODO)
    $i18n = sfContext::getInstance()->getI18N();
    foreach (sfSocialEventUser::$choices as $k => $choice)
    {
      $i18nChoice[$k] = $i18n->__($choice, null, 'sfSocial');
    }
    $this->widgetSchema['confirm'] = new sfWidgetFormChoice(array(
      'choices'  => $i18nChoice,
      'expanded' => true,
    ));

    // make user_id hidden
    $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_id', $this->options['user']->getId());
    $this->setValidator('user_id', new sfValidatorChoice(array('choices' => array($this->options['user']->getId()))));

    // make event_id hidden
    $this->widgetSchema['event_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('event_id', $this->options['event']->getId());
    $this->setValidator('event_id', new sfValidatorChoice(array('choices' => array($this->options['event']->getId()))));
  }

  /**
   * ovveride: when save, if user previously confirmed and now doesn't,
   *  it needs to remove it from sfSocialEventUser
   * @param PropelPDO $con
   *
  public function doSave($con = null)
  {
    $obj = $this->getObject();
    if (!$obj->isNew() && $this->getValue('confirm'))
    {

    }
    else
    {
#var_dump($this->getObject());die;
      parent::doSave();
    }
  }
*/
}
