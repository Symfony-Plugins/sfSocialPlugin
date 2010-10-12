// sfSocial group invites

$(document).ready(function() {
  sfsgrp.init();
});

sfsgrp =
{

  // call sfsac
  init: function()
  {
    sfsac.remove_txt = $('#remove_text').attr('value');
    sfsac.ajax_url = $('#ajax_search').attr('value');
    sfsac.init('invites', 'sf_social_group_invite_user_id', sfsgrp.validate);
  },

  // validate form
  validate: function(e)
  {
    // recipients
    if ($('div#users span').length == 0)
    {
      alert('Error: recipients missing');
      return false;
    }
    return true;
  }

}