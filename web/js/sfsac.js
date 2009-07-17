// sfSocialAutoComplete
sfsac =
{

  remove_txt: 'Remove',
  ajax_url: '',
  img_path: '/uploads/sf_social_pics/thumbnails/',
  img_def: '/sfSocialPlugin/images/default.jpg',

  // users
  users: [],

  // look for form and add events
  init: function(form_id, select_id, validate_func)
  {
    // get form
    var form = document.getElementById(form_id);
    if (!form)
    {
      return;
    }
    // add client validation
    if (validate_func !== undefined)
    {
      YAHOO.util.Event.addListener(form, 'submit', validate_func);
    }
    // get "to" field
    var to = document.getElementById(select_id);
    if (!to)
    {
      return;
    }
    // save name of "to" field, to use it in "add" function
    sfsac.toname = to.getAttribute('name');
    // get possible selected values of field
    var selected = to.options.selectedIndex > -1 ? to.options[to.options.selectedIndex] : null;
    // create a container for autocomplete
    var div = document.createElement('div');
    div.setAttribute('id', 'ac_cont');
    div.setAttribute('class', 'yui-ac');
    to.parentNode.appendChild(div);
    // remove "to" field
    to.parentNode.removeChild(to);
    // add a container for users
    var users = document.createElement('div');
    users.setAttribute('id', 'users');
    div.appendChild(users);
    // add possible selected values
    if (selected)
    {
      sfsac.add(selected.value, selected.text);
    }
    // add a new input field
    var input = document.createElement('input');
    input.setAttribute('id', 'usrinput');
    div.appendChild(input);
    // add auto-complete to new input field
    form.setAttribute('class', 'yui-skin-sam');
    var ydiv = document.createElement('div');
    ydiv.setAttribute('id', 'yuicont');
    input.parentNode.appendChild(ydiv);
    sfsac.autocomplete();
  },

  // add autocomplete to a field
  autocomplete: function()
  {
    var ds = new YAHOO.util.XHRDataSource(sfsac.ajax_url);
    ds.responseType = YAHOO.util.XHRDataSource.TYPE_JSON;
    ds.responseSchema = {
      resultsList : 'users',
      fields : ['id', 'name', 'img']
    }
    var ac = new YAHOO.widget.AutoComplete('usrinput', 'yuicont', ds);
    ac.minQueryLength = 1;
    ac.forceSelection = true;
    ac.generateRequest = function(sQuery)
    {
      if (sfsac.users.length > 0)
      {
        // exclude already selected users
        return '/exclude_ids/' + sfsac.users + '/text/' + sQuery;
      }
      else
      {
        return '/text/' + sQuery;
      }
    }
    ac.formatResult = function(oRes, sQuery, sResMatch)
    {
      if (oRes[2] !== null)
      {
        return '<img src="' + sfsac.img_path + oRes[2] + '" /> ' + oRes[1];
      }
      else
      {
        return '<img src="' + sfsac.img_def + '" /> ' + oRes[1];
      }
    }
    var myHandler = function(sType, aArgs)
    {
      var oData = aArgs[2];
      sfsac.add(oData[0], oData[1]);
      var input = document.getElementById('usrinput');
      input.value = '';
    };
    ac.itemSelectEvent.subscribe(myHandler);
  },

  // add selected id/name to users' list
  // data = [id, name] e.g.: 4, mario
  add: function(id, name)
  {
    var users = document.getElementById('users');
    // create a span with selected name inside
    var span = document.createElement('span');
    span.appendChild(document.createTextNode(name));
    // add a remove link ("X") with id inside
    var a = document.createElement('a');
    a.appendChild(document.createTextNode('x'));
    a.setAttribute('href', '#' + id);
    a.setAttribute('title', sfsac.remove_txt);
    YAHOO.util.Event.addListener(a, 'click', sfsac.remove);
    span.appendChild(a);
    // add hidden input with id inside
    var ih = document.createElement('input');
    ih.setAttribute('type', 'hidden');
    ih.setAttribute('name', sfsac.toname);
    ih.setAttribute('value', id);
    span.appendChild(ih);
    // insert span in div
    users.appendChild(span);
    // add to users array
    sfsac.users.push(id);
  },

  // remove an user
  remove: function(e)
  {
    var a = YAHOO.util.Event.getTarget(e);
    YAHOO.util.Event.preventDefault(e);
    // get id
    var id = a.getAttribute('href').substr(1);
    // remove span
    var span = a.parentNode;
    span.parentNode.removeChild(span);
    // remove from sfsac.users array
    for (var key in sfsac.users)
    {
      if (sfsac.users[key] == id)
      {
        sfsac.users.splice(key, 1);
      }
    }
  }

}