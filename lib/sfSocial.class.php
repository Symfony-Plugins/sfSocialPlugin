<?php

/**
 * sfSocial class. Contains common static function to
 * other sfSocialPlugin's modules
 *
 * @package     sfSocialPlugin
 * @author      Geoffroy Charollais <geoffroy.charollais@gmail.com>
 */

class sfSocial
{
  // sex choices

  const SEX_UNSPECIFIED = '';
  const SEX_MALE        = 'M';
  const SEX_FEMALE      = 'F';
  
  static public $sexChoices = array(self::SEX_UNSPECIFIED => 'Unspecified',
                                    self::SEX_MALE        => 'Male',
                                    self::SEX_FEMALE      => 'Female');

  /**
   * Get the I18n array of choices from the one
   * given in parameter, if i18n enabled.
   * @param array $choices An array instance of choices
   */
  static public function getI18NChoices(array $choices)
  {
    if (sfConfig::get('sf_i18n'))
    {
      // make confirm a choice (i18n solution is very ugly, is there a better way? TODO)
      $i18n = sfContext::getInstance()->getI18N();
      foreach ($choices as $k => $choice)
      {
        $i18nChoices[$k] = $i18n->__($choice, null, 'sfSocial');
      }
      return $i18nChoices;
    }
    else
    {
      return $choices;
    }
  }
}
