<?php

/**
 * sfSocialEvent form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialEventForm extends BasesfSocialEventForm
{
  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at'], $this['updated_at'], $this['sf_social_event_user_list']);

    // hide user_admin, binding it to current user's id
    $uid = sfContext::getInstance()->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
    $this->widgetSchema['user_admin'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_admin', $uid);
    $this->setValidator('user_admin', new sfValidatorChoice(array('choices' => array($uid))));

    // set selectable dates
    $years = range(date('Y'), date('Y') + 5);
    $ylist = array_combine($years, $years);
    $this->widgetSchema['start']->setOption('date', array('years' => $ylist));
    $this->widgetSchema['end']->setOption('date', array('years' => $ylist));

    // set default dates (today and tomorrow)
    $this->setDefault('start', time());
    $this->setDefault('end', time() + 86400);
  }
}
