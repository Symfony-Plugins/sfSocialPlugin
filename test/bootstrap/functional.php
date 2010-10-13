<?php

require_once dirname(__FILE__) . '/../../../../config/ProjectConfiguration.class.php';

sfCoreAutoload::register();

// possibly adapt application name ("frontend" here)
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
sfContext::createInstance($configuration);

require_once dirname(__FILE__) . '/../../config/sfSocialPluginConfiguration.class.php';
$plugin_configuration = new sfSocialPluginConfiguration($configuration, dirname(__FILE__) . '/../..');

// don't use sfSimpleAutoload. See http://trac.symfony-project.org/ticket/8976
$sal = sfSimpleAutoload::getInstance();
$sal->unregister();
$al = sfAutoload::getInstance();
$al->register();

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));

// import fixture data
$data = new sfPropelData();
$data->loadData(dirname(__FILE__) . '/../../data/fixtures');