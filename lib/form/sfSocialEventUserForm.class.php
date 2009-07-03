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

    // make confirm a choice
    $this->widgetSchema['confirm'] = new sfWidgetFormChoice(array(
      'choices'  => sfSocialEventUser::$choices,
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

}
