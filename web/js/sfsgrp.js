// sfSocial group invites
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
    if ($('#sfsm_to').length < 1)
    {
      alert('Error: recipients missing');
      return false;
    }
    return true;
  }

}

$(document).ready(function()
{
  sfsgrp.init();
});