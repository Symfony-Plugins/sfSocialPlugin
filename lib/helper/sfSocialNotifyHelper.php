<?php

/**
 * get notify message
 * @param  sfSocialNotify $notify
 * @return string
 */
function getSfSocialNotifyMessage(sfSocialNotify $notify)
{
#var_dump($notify->getModel())  ;die;
  $notify->setModel();
  switch ($notify->getModelName())
  {
    case 'sfSocialMessage':
      return __('You received a %1% from <u>%2%</u>', // TODO user link
                array('%1%' => link_to(__('message'),
                                          '@sf_social_notify?id=' . $notify->getId()),
                      '%2%' => $notify->getModel()->getSfGuardUser()->getUsername()
                      )
                );
      // TODO other models
  }

}
