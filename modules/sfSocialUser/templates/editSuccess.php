<h2><?php echo __('Edit profile', null, 'sfSocial') ?></h2>

<form action="<?php echo url_for('@sf_social_user_edit?username=' . $user) ?>" method="post" enctype="multipart/form-data">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_user?username=' . $user, 'class=cancel') ?>
      <input type="submit" value="<?php echo __('edit', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>