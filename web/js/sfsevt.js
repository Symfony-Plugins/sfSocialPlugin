// sfSocial event invites

$(document).ready(function() {
  sfsevt.init();
});

sfsevt =
{

  // call sfsac
  init: function()
  {
    sfsac.users = sfsevt.getInvited();
    sfsac.remove_txt = $('#remove_text').attr('value');
    sfsac.ajax_url = $('#ajax_search').attr('value');
    sfsac.init('invites', 'sf_social_event_invite_user_id', sfsevt.validate);
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
  },

  // get already invited users
  getInvited: function()
  {
    var ids = [];
    $('ul#confirmed li a').each(function() {
      ids.push($(this).attr('rel'));
    });
    $('ul#maybe li a').each(function() {
      ids.push($(this).attr('rel'));
    });
    $('ul#not li a').each(function() {
      ids.push($(this).attr('rel'));
    });
    $('ul#invited li a').each(function() {
      ids.push($(this).attr('rel'));
    });

    return ids;
  }

}