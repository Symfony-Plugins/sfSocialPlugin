<?php

/**
 * sfSocialProfile form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialProfileForm extends sfGuardUserForm
{

  // "sex" choices
  const SEX_UNKNOWN = '';
  const SEX_MALE    = 'M';
  const SEX_FEMALE  = 'F';
  static public $sexChoices = array(self::SEX_UNKNOWN => 'Unspecified',
                                    self::SEX_MALE    => 'Male',
                                    self::SEX_FEMALE  => 'Female');

  public function configure()
  {
    parent::configure();

    // fields to hide
    unset($this['username'], $this['sf_social_event_user_list'], $this['sf_social_group_user_list']);

    // add more years to birthday
    $years = range(date('Y'), 1900);
    $this->widgetSchema['birthday']->setOption('years', array_combine($years, $years));

    // make "sex" a choice
    $this->widgetSchema['sex'] = new sfWidgetFormChoice(array('expanded' => false,
                                                              'choices' => self::$sexChoices));
    $this->validatorSchema['sex'] = new sfValidatorChoice(array('required' => false,
                                                                'choices' => array_keys(self::$sexChoices)));

    // make picture editable
    $path = sfConfig::get('app_sf_social_pic_path', '/sf_social_pics/');
    $maxsize = sfConfig::get('app_sf_social_pic_maxsize', 30000);
    $this->widgetSchema['picture'] = new sfWidgetFormInputFileEditable(array('file_src' => '/uploads' . $path . $this->getObject()->getProfile()->getPicture(),
                                                                             'is_image' => true));
    $this->validatorSchema['picture'] = new sfValidatorFile(array('required' => false,
                                                                  'mime_types' => 'web_images',
                                                                  'max_size' => $maxsize,
                                                                  'validated_file_class' => 'sfSocialValidatedFile',
                                                                  'path' => sfConfig::get('sf_upload_dir') . $path));
  }

  /**
   * ovveride "save" to set user's name as file's name
   */
  public function save($con = null)
  {
    if ($file = $this->getValue('picture'))
    {
      $picname = $this->getObject()->getUsername() . $file->getExtension();
      $file->save($picname);
    }
    parent::save($con);
  }

}

/**
 * extension of symfony's sfValidatedFile
 */
require_once sfConfig::get('sf_symfony_lib_dir') . '/validator/sfValidatorFile.class.php';
class sfSocialValidatedFile extends sfValidatedFile
{

  /**
   * Returns the name of the saved file.
   */
  public function __toString()
  {
    return is_null($this->savedName) ? '' : basename($this->savedName);
  }

  /**
   * Saves the uploaded file.
   * @param  string $file      The file path to save the file
   * @param  int    $fileMode  The octal mode to use for the new file
   * @param  bool   $create    Indicates that we should make the directory before moving the file
   * @param  int    $dirMode   The octal mode to use when creating the directory
   */
  public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    parent::save($file, $fileMode, $create, $dirMode);
    $this->saveThumb($file);
  }

  /**
   * save a thumbnail of image
   * @param string $file
   */
  public function saveThumb($file)
  {
    $path = sfConfig::get('app_sf_social_pic_path', '/sf_social_pics/');
    $size = sfConfig::get('app_sf_social_thumb_size', 50);
    // TODO this is ugly... is there another way to check if a plugin is enabled?
    if (in_array('sfThumbnailPlugin', sfContext::getInstance()->getConfiguration()->getPlugins()))
    {
      $thumbnail = new sfThumbnail($size, $size);
      $thumbnail->loadFile($this->getSavedName());
      $thumbnail->save(sfConfig::get('sf_upload_dir') . $path . 'thumbnails/' . $file);
    }
  }

}
