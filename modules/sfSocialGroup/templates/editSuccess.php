<h2><?php echo __('Edit group &quot;%1%&quot;', array('%1%' => $group->getTitle()), 'sfSocial') ?></h2>

<form action="<?php echo url_for('sf_social_group_edit', $group) ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_group_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('edit', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
