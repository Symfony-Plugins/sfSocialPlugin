<?php

// TODO hard-coded!
#require_once '/usr/share/php/symfony/autoload/sfCoreAutoload.class.php';
#sfCoreAutoload::register();

require_once dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php';
#require_once dirname(__FILE__).'/../fixtures/project/config/ProjectConfiguration.class.php';

#$configuration = new ProjectConfiguration(realpath(dirname(__FILE__).'/../../../..'));
sfCoreAutoload::register();

$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);

require_once dirname(__FILE__).'/../../config/sfSocialPluginConfiguration.class.php';
$plugin_configuration = new sfSocialPluginConfiguration($configuration, dirname(__FILE__).'/../..');

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));
