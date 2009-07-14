<?php

/**
 * sfSocialPlugin configuration.
 *
 * @package     sfSocialPlugin
 * @subpackage  config
 * @author      Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $modules = sfConfig::get('sf_enabled_modules', array());
    if (in_array('sfSocialNotify', $modules))
    {
      if (in_array('sfSocialMessage', $modules))
      {
        $this->dispatcher->connect('social.write_message', array('sfSocialNotifyListener',
                                                                 'listenToWriteMessage'));
      }
      if (in_array('sfSocialEvent', $modules))
      {
        $this->dispatcher->connect('social.event_invite', array('sfSocialNotifyListener',
                                                                'listenToEventInvite'));
      }
      if (in_array('sfSocialGroup', $modules))
      {
        $this->dispatcher->connect('social.group_invite', array('sfSocialNotifyListener',
                                                                'listenToGroupInvite'));
      }
      if (in_array('sfSocialContact', $modules))
      {
        $this->dispatcher->connect('social.contact_request', array('sfSocialNotifyListener',
                                                                   'listenToContactRequest'));
      }
    }
  }
}
