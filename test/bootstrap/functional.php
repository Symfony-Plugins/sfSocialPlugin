<?php

require_once dirname(__FILE__) . '/../../../../config/ProjectConfiguration.class.php';

sfCoreAutoload::register();

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
sfContext::createInstance($configuration);

require_once dirname(__FILE__) . '/../../config/sfSocialPluginConfiguration.class.php';
$plugin_configuration = new sfSocialPluginConfiguration($configuration, dirname(__FILE__) . '/../..');

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));

// clear fixture data
new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true));

$tables = array('sf_social' => array('contact', 'contact_group', 'contact_group_contact',
                  'contact_request', 'event', 'event_invite',
                  'event_user', 'group', 'group_invite', 'group_user',
                  'message', 'message_rcpt', 'notify'),
                'sf_guard' => array('group', 'group_permission', 'permission', 'user',
                  'user_group', 'user_permission'));
$con = Propel::getConnection();
foreach ($tables as $plugin => $table)
{
  foreach ($table as $model)
  {
    $stmt = $con->prepare('TRUNCATE TABLE ' . $plugin . '_' . $model);
    $stmt->execute();
  }
}

// re-import fixture data
$data = new sfPropelData();
$data->loadData(dirname(__FILE__) . '/../../data/fixtures');