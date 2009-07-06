<h2><?php echo __('New group') ?></h2>
<form action="<?php echo url_for('@sf_social_group_new') ?>" method="post">
  <ul id="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel'), '@sf_social_group_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('create') ?>" />
    </li>
  </ul>
</form>
