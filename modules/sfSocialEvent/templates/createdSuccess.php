<h2>OK</h2>
<?php if ($isNew): ?>
<?php echo  __('Event successfully created') ?>
<?php else: ?>
<?php echo __('Event successfully updated') ?>
<?php endif ?>

<p />
<?php echo link_to('Back to event', '@sf_social_event?id=' . $event->getId()) ?>