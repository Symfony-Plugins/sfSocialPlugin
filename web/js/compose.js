// sfSocial message compose

$(document).ready(function() {
  sfsmsg.init();
});

sfsmsg =
{

  // call sfsac
  init: function()
  {
    sfsac.remove_txt = $('#remove_text').attr('value');
    sfsac.ajax_url = $('#ajax_search').attr('value');
    sfsac.init('compose_message', 'sf_social_message_to', sfsmsg.validate);
  },

  // validate form
  validate: function(e)
  {
    // subject
    if ($('#sf_social_message_subject').attr('value').length < 2)
    {
      alert('Error: subject missing');
      return false;
    }
    // text
    if ($('#sf_social_message_text').attr('value').length < 3)
    {
      alert('Error: text missing');
      return false;
    }
    // recipients
    if ($('div#users span').length == 0)
    {
      alert('Error: recipients missing');
      return false;
    }
    return true;
  }

}