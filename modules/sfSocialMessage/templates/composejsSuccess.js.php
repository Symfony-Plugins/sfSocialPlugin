sfsmsg =
{

  // recipients
  rcpts: [],

  // look for form and add events
  init: function()
  {
    // get form
    var form = document.getElementById('compose_message');
    if (!form)
    {
      return;
    }
    // add client validation
    YAHOO.util.Event.addListener(form, 'submit', sfsmsg.validate);
    // get "to" field
    var to = document.getElementById('sf_social_message_to');
    if (!to)
    {
      return;
    }
    // save name of "to" field, to use it in "add" function
    sfsmsg.toname = to.getAttribute('name');
    // get possible selected values of field
    var selected = to.options.selectedIndex > -1 ? to.options[to.options.selectedIndex] : null;
    // create a container for autocomplete
    var div = document.createElement('div');
    div.setAttribute('id', 'msgcont');
    div.setAttribute('class', 'yui-ac');
    to.parentNode.appendChild(div);
    // remove "to" field
    to.parentNode.removeChild(to);
    // add a container for rcpt names
    var rcpts = document.createElement('div');
    rcpts.setAttribute('id', 'rcpts');
    div.appendChild(rcpts);
    // add possible selected values
    if (selected)
    {
      sfsmsg.add(selected.value, selected.text);
    }
    // add a new input field
    var input = document.createElement('input');
    input.setAttribute('id', 'msginput');
    div.appendChild(input);
    // add auto-complete to new input field
    form.setAttribute('class', 'yui-skin-sam');
    var ydiv = document.createElement('div');
    ydiv.setAttribute('id', 'yuicont');
    input.parentNode.appendChild(ydiv);
    sfsmsg.autocomplete();
  },

  // validate form
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
      alert('Error: recipient missing');
      return;
    }
    // OK
    form.submit();
  },

  // add autocomplete to a field
  autocomplete: function()
  {
    var ds = new YAHOO.util.XHRDataSource('<?php echo url_for('@sf_social_contact_search') ?>');
    ds.responseType = YAHOO.util.XHRDataSource.TYPE_JSON;
    ds.responseSchema = {
      resultsList : 'users',
      fields : ['id', 'name']
    }
    var ac = new YAHOO.widget.AutoComplete('msginput', 'yuicont', ds);
    ac.minQueryLength = 1;
    ac.forceSelection = true;
    ac.generateRequest = function(sQuery)
    {
      if (sfsmsg.rcpts.length > 0)
      {
        // exclude already selected rcpts
        return '/exclude_ids/' + sfsmsg.rcpts + '/text/' + sQuery;
      }
      else
      {
        return '/text/' + sQuery;
      }
    }
    ac.formatResult = function(oRes, sQuery, sResMatch)
    {
      var ret = oRes[1];
      return ret;
    }
    var myHandler = function(sType, aArgs)
    {
      var oData = aArgs[2];
      sfsmsg.add(oData[0], oData[1]);
      var input = document.getElementById('msginput');
      input.value = '';
    };
    ac.itemSelectEvent.subscribe(myHandler);
  },

  // add selected id/name to rpcts. data = [id, name] e.g.: 4,mario
  add: function(id, name)
  {
    var rcpts = document.getElementById('rcpts');
    // create a span with selected name inside
    var span = document.createElement('span');
    span.appendChild(document.createTextNode(name));
    // add a remove link ("X") with id inside
    var a = document.createElement('a');
    a.appendChild(document.createTextNode('x'));
    a.setAttribute('href', '#' + id);
    a.setAttribute('title', '<?php echo __('remove', null, 'sfSocial') ?>');
    YAHOO.util.Event.addListener(a, 'click', sfsmsg.remove);
    span.appendChild(a);
    // add hidden input with id inside
    var ih = document.createElement('input');
    ih.setAttribute('type', 'hidden');
    ih.setAttribute('name', sfsmsg.toname);
    ih.setAttribute('value', id);
    span.appendChild(ih);
    // insert span in div
    rcpts.appendChild(span);
    // add to rcpts array
    sfsmsg.rcpts.push(id);
  },

  // remove rpct
  remove: function(e)
  {
    var a = YAHOO.util.Event.getTarget(e);
    YAHOO.util.Event.preventDefault(e);
    // get id
    var id = a.getAttribute('href').substr(1);
    // remove span
    var span = a.parentNode;
    span.parentNode.removeChild(span);
    // remove from sfsmsg.rcpts array
    for (var key in sfsmsg.rcpts)
    {
      if (sfsmsg.rcpts[key] == id)
      {
        sfsmsg.rcpts.splice(key, 1);
      }
    }
  }

}

YAHOO.util.Event.addListener(window, 'load', sfsmsg.init);