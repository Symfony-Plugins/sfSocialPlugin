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
      // TODO connect to other listeners here
    }

  }
}
