<h2><?php echo __('Edit event &quot;%1%&quot;', array('%1%' => $event->getTitle()), 'sfSocial') ?></h2>
<form action="<?php echo url_for('sf_social_event_edit', $event) ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_event_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('edit', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
