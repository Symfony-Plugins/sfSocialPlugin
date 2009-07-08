<h2><?php echo __('New event', null, 'sfSocial') ?></h2>
<form action="<?php echo url_for('@sf_social_event_new') ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_event_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('create', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
