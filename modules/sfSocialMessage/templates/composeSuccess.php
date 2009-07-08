<?php use_stylesheet('http://yui.yahooapis.com/2.7.0/build/autocomplete/assets/skins/sam/autocomplete.css') ?>
<?php use_stylesheet('/sfSocialPlugin/css/message') ?>
<?php use_javascript('http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js') ?>
<?php use_javascript('http://yui.yahooapis.com/2.7.0/build/datasource/datasource-min.js') ?>
<?php use_javascript('http://yui.yahooapis.com/2.7.0/build/connection/connection-min.js') ?>
<?php use_javascript('http://yui.yahooapis.com/2.7.0/build/autocomplete/autocomplete-min.js') ?>
<?php use_javascript(url_for('@sf_social_message_js')) ?>
<h2><?php echo __('Compose a new message', null, 'sfSocial') ?></h2>

<form id="compose_message" action="<?php echo url_for('@sf_social_message_new') ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_message_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('send', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
