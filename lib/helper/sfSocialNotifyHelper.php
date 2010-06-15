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
                                          'sf_social_notify', $notify),
                      '%2%' => link_to($notify->getModel()->getFrom(), 'sf_social_user', $notify->getModel()->getFrom())
                    ),
                'sfSocial'
                );
    case 'sfSocialContactRequest':
      return __('You received a %1% from %2%',
                array('%1%' => link_to(__('contact request', null, 'sfSocial'),
                                          'sf_social_notify', $notify),
                      '%2%' => link_to($notify->getModel()->getFrom(), 'sf_social_user', $notify->getModel()->getFrom())
                    ),
                'sfSocial'
                );
    case 'sfSocialEventInvite':
      return __('You received an %1% from %2%',
                array('%1%' => link_to(__('invite to event %event%', array('%event%' => $notify->getModel()->getEvent()), 'sfSocial'),
                                          'sf_social_notify', $notify),
                      '%2%' => link_to($notify->getModel()->getFrom(), 'sf_social_user' , $notify->getModel()->getFrom())
                    ),
                'sfSocial'
                );
    case 'sfSocialGroupInvite':
      return __('You received an %1% from %2%',
                array('%1%' => link_to(__('invite to join group %group%', array('%group%' => $notify->getModel()->getGroup()), 'sfSocial'),
                                          'sf_social_notify', $notify),
                      '%2%' => link_to($notify->getModel()->getFrom(), 'sf_social_user' , $notify->getModel()->getFrom())
                    ),
                'sfSocial'
                );
  }

}
