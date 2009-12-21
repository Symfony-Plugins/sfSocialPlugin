// sfSocial event invites
sfsevt =
{

  // call sfsac
  init: function()
  {
    sfsac.remove_txt = $('#remove_text').attr('value');
    sfsac.ajax_url = $('#ajax_search').attr('value');
    sfsac.init('invites', 'sf_social_event_invite_user_id', sfsevt.validate);
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
  sfsevt.init();
});