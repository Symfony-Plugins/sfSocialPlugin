// sfSocial group invites
sfsgrp =
{

  // call sfsac
  init: function()
  {
    sfsac.remove_txt = '<?php echo __('remove', null, 'sfSocial') ?>';
    sfsac.ajax_url = '<?php echo url_for('@sf_social_contact_search') ?>';
    sfsac.init('invites', 'sf_social_group_invite_user_id', sfsgrp.validate);
  },

  // validate form
  validate: function(e)
  {
    var form = YAHOO.util.Event.getTarget(e);
    // rcpts
    if (sfsgrp.rcpts-length < 1)
    {
      alert('Error: users missing');
      return;
    }
    // OK
    form.submit();
  }

}

YAHOO.util.Event.addListener(window, 'load', sfsgrp.init);