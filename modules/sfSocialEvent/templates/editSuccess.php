<h2><?php echo __('Edit event ') ?> &quot;<?php echo $event->getTitle() ?>&quot;</h2>
<form action="<?php echo url_for('@sf_social_event_edit?id=' . $event->getId()) ?>" method="post">
  <ul id="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel'), '@sf_social_event_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('edit') ?>" />
    </li>
  </ul>
</form>
