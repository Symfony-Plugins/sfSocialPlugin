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
    if (in_array('sfSocialNotify', sfConfig::get('sf_enabled_modules', array())))
    {
      $this->dispatcher->connect('social.write_message', array('sfSocialNotifyListener', 'listenToWriteMessage'));
      // TODO connect to other listeners here
    }

  }
}
