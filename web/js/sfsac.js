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
    var form = $('#' + form_id);
    if (!form)
    {
      return;
    }
    // add client validation
    if (validate_func !== undefined)
    {
      form.submit(validate_func);
    }
    // get "to" field
    var to = $('#' + select_id);
    if (!to)
    {
      return;
    }
    // save name of "to" field, to use it in "add" function
    sfsac.toname = to.attr('name');
    // get possible selected values of field
    var selected = $('#' + select_id + ' option:selected');
    // remove "to" field
    var prnt = to.parent();
    to.remove();
    // add a container for users
    var users = $('<div id="users">');
    prnt.append(users);
    // add possible selected values
    if (selected)
    {
      sfsac.add(selected.value, selected.text);
    }
    // add a new input field
    var input = $('<input id="usrinput">');
    prnt.append(input);
    // add auto-complete to new input field
    input.autocomplete(sfsac.ajax_url, {
        width: 320,
        max: 5,
        scroll: true,
        scrollHeight: 300,
      cacheLength: 0,
        extraParams: { exclude_ids: function() { return sfsac.users.join(','); } },
      parse: sfsac.parse,
        formatItem: function(data, i, n, value) {
        if (data.img)
          {
          return '<img src="' + sfsac.img_path + data.img + '" /> ' + data.name;
          }
          else
          {
          return '<img src="' + sfsac.img_def + '" /> ' + data.name;
          }
        }
      });
    input.result(function(event, data, formatted)
    {
      if (data)
      {
        sfsac.add(data.id, data.name);
        this.value = '';
      }
    });
  },

  // redefine original autocomplete parse function
  parse: function(qdata)
  {
    var parsed = [];
    for (var i in qdata)
    {
      parsed[parsed.length] = {
        data: qdata[i],
        value: qdata[i].name,
        result: qdata[i].name
      };
    }
    return parsed;
  },

  // add selected id/name to users' list
  // data = [id, name] e.g.: 4, mario
  add: function(id, name)
  {
    if (!id)
    {
      return;
    }
    var users = $('#users');
    // create a span with selected name inside
    var span = $('<span>');
    span.append(name);
    // add a remove link ("X") with id inside
    var a = $('<a href="#' + id + '" title="' + sfsac.remove_txt +'">');
    a.append('x');
    a.click(sfsac.remove);
    span.append(a);
    // add hidden input with id inside
    var ih = $('<input type="hidden" name="' + sfsac.toname + '" value="' + id + '">');
    span.append(ih);
    // insert span in div
    users.append(span);
    // add to users array
    sfsac.users.push(id);
  },

  // remove an user
  remove: function(e)
  {
    // get id
    var id = $(this).attr('href').substr(1);
    // remove span
    $(this).parent().remove();
    // remove from sfsac.users array
    for (var key in sfsac.users)
    {
      if (sfsac.users[key] == id)
      {
        sfsac.users.splice(key, 1);
      }
    }
    return false;
  }

}