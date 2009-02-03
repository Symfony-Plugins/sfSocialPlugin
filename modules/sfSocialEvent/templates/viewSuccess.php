<h2><?php echo __('Event') ?> &quot;<?php echo $event->getTitle() ?>&quot;</h2>

<h3><?php echo __('When') ?>: <?php echo $event->getWhen() ?></h3>

<div id="event_body">
  <?php echo $event->getDescription() ?>
</div>

<div id="event_confirm">
<form action="<?php echo url_for('@sf_social_event?id=' . $event->getId()) ?>" method="post">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
</div>

<?php if ($isAdmin): ?>
<?php echo link_to(__('Edit event'), '@sf_social_event_edit?id=' . $event->getId()) ?>
<h3><?php echo __('Invite:') ?></h3>
<div id="event_invite">
<form action="<?php echo url_for('@sf_social_event_invite?id=' . $event->getId()) ?>" method="post">
  <table>
    <?php echo $form2 ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
</div>
<?php endif ?>

<hr />

<?php if ($event->getEnd() > time()): ?>
<?php echo link_to(__('Back to list'), '@sf_social_event_pastlist') ?>
<?php else: ?>
<?php echo link_to(__('Back to list'), '@sf_social_event_list') ?>
<?php endif ?>