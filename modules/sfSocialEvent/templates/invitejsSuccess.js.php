// sfSocial event invites
sfsevt =
{

  // call sfsac
  init: function()
  {
    sfsac.remove_txt = '<?php echo __('remove', null, 'sfSocial') ?>';
    sfsac.ajax_url = '<?php echo url_for('@sf_social_contact_search') ?>';
    sfsac.init('invites', 'sf_social_event_invite_user_id', sfsevt.validate);
  },

  // validate form
  validate: function(e)
  {
    var form = YAHOO.util.Event.getTarget(e);
    // rcpts
    if (sfsevt.rcpts-length < 1)
    {
      alert('Error: users missing');
      return;
    }
    // OK
    form.submit();
  }

}

YAHOO.util.Event.addListener(window, 'load', sfsevt.init);