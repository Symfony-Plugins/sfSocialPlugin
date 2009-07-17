// sfSocial message compose
sfsmsg =
{

  // call sfsac
  init: function()
  {
    sfsac.remove_txt = '<?php echo __('remove', null, 'sfSocial') ?>';
    sfsac.ajax_url = '<?php echo url_for('@sf_social_contact_search') ?>';
    sfsac.init('compose_message', 'sf_social_message_to', sfsmsg.validate);
  },

  // validate form TODO translate errors
  validate: function(e)
  {
    var form = YAHOO.util.Event.getTarget(e);
    YAHOO.util.Event.preventDefault(e);
    // subject
    var subject = document.getElementById('sf_social_message_subject');
    if (!subject || subject.value.length < 2)
    {
      alert('Error: subject missing');
      return;
    }
    // text
    var text = document.getElementById('sf_social_message_text');
    if (!text || text.value.length < 2)
    {
      alert('Error: text missing');
      return;
    }
    // rcpts
    if (sfsmsg.rcpts-length < 1)
    {
      alert('Error: recipients missing');
      return;
    }
    // OK
    form.submit();
  }

}

YAHOO.util.Event.addListener(window, 'load', sfsmsg.init);