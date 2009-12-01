<?php

/**
 * get notify message
 * @param  sfSocialNotify $notify
 * @return string
 */
function getSfSocialNotifyMessage(sfSocialNotify $notify)
{
  $notify->setModel();
  switch ($notify->getModelName())
  {
    case 'sfSocialMessage':
      return __('You received a %1% from %2%',
                array('%1%' => link_to(__('message', null, 'sfSocial'),
                                          '@sf_social_notify?id=' . $notify->getId()),
                      '%2%' => link_to($notify->getModel()->getSfGuardUser(), '@sf_social_user?username=' . $notify->getModel()->getSfGuardUser())
                    ),
                'sfSocial'
                );
    case 'sfSocialContactRequest':
      return __('You received a %1% from %2%',
                array('%1%' => link_to(__('contact request', null, 'sfSocial'),
                                          '@sf_social_notify?id=' . $notify->getId()),
                      '%2%' => link_to($notify->getModel()->getSfGuardUserRelatedByUserFrom(), '@sf_social_user?username=' . $notify->getModel()->getSfGuardUserRelatedByUserFrom())
                    ),
                'sfSocial'
                );
    case 'sfSocialEventInvite':
      return __('You received an %1% from %2%',
                array('%1%' => link_to(__('invite to event %event%', array('%event%' => $notify->getModel()->getsfSocialEvent()), 'sfSocial'),
                                          '@sf_social_notify?id=' . $notify->getId()),
                      '%2%' => link_to($notify->getModel()->getSfGuardUserRelatedByUserFrom(), '@sf_social_user?username=' . $notify->getModel()->getSfGuardUserRelatedByUserFrom())
                    ),
                'sfSocial'
                );
    case 'sfSocialGroupInvite':
      return __('You received an %1% from %2%',
                array('%1%' => link_to(__('invite to join group %group%', array('%group%' => $notify->getModel()->getsfSocialGroup()), 'sfSocial'),
                                          '@sf_social_notify?id=' . $notify->getId()),
                      '%2%' => link_to($notify->getModel()->getSfGuardUserRelatedByUserFrom(), '@sf_social_user?username=' . $notify->getModel()->getSfGuardUserRelatedByUserFrom())
                    ),
                'sfSocial'
                );
  }

}
