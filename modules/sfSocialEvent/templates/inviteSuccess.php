<h2><?php echo __('Invite to event &quot;%1%&quot;', array('%1%' => $event->getTitle()), 'sfSocial') ?></h2>

<?php if ($form->isValid()): ?>
<?php echo __('User invited', null, 'sfSocial') ?>
<?php endif ?>

<div id="event_invite">
  <form action="<?php echo url_for('@sf_social_event_invite?id=' . $event->getId()) ?>" method="post">
    <ul class="form">
      <?php echo $form ?>
      <li class="buttons">
        <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_event?id=' . $event->getId(), 'class=cancel') ?>
        <input type="submit" value="<?php echo __('invite', null, 'sfSocial') ?>" />
      </li>
    </ul>
  </form>
</div>