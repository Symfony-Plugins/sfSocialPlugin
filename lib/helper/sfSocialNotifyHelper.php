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
      return __('You received a %1% from %2%',
                array('%1%' => link_to(__('message'),
                                          '@sf_social_notify?id=' . $notify->getId()),
                      '%2%' => link_to($notify->getModel()->getSfGuardUser(), '@sf_social_user?username=' . $notify->getModel()->getSfGuardUser())
                      )
                );
      // TODO other models
  }

}
