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
