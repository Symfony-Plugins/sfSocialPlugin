<h2><?php echo __('Edit group') ?> &quot;<?php echo $group->getTitle() ?>&quot;</h2>
<form action="<?php echo url_for('@sf_social_group_edit?id=' . $group->getId()) ?>" method="post">
  <ul id="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel'), '@sf_social_group_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('edit') ?>" />
    </li>
  </ul>
</form>
