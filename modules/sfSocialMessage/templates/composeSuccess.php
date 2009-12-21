<h2><?php echo __('Compose a new message', null, 'sfSocial') ?></h2>

<form id="compose_message" action="<?php echo url_for('@sf_social_message_new') ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_message_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('send', null, 'sfSocial') ?>" />
      <input type="hidden" id="ajax_search" value="<?php echo url_for('@sf_social_contact_search') ?>" />
      <input type="hidden" id="remove_text" value="<?php echo __('remove', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>