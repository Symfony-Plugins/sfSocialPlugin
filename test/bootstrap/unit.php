<?php



require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');
$configuration = new ProjectConfiguration(realpath(dirname(__FILE__).'/../../../..'));
sfCoreAutoload::register();

require_once $configuration->getSymfonyLibDir().'/vendor/lime/lime.php';

require_once dirname(__FILE__).'/../../config/sfSocialPluginConfiguration.class.php';
$plugin_configuration = new sfSocialPluginConfiguration($configuration, dirname(__FILE__).'/../..');
