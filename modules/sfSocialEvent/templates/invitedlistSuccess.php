<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No invite received yet') ?></h2>
<?php else: ?>
<h2><?php echo __('Invites received for events') ?></h2>
<ul>
<?php foreach ($pager->getResults() as $invite): ?>
<?php $event = $invite->getSfSocialEvent() ?>
  <li>
    <?php echo link_to($event, '@sf_social_event?id=' . $event->getId()) ?>
    <?php echo $event->getWhen() ?>
    <?php echo __('in') ?> <?php echo $event->getLocation() ?>
    - <?php echo __('from') ?> <?php echo link_to($invite->getSfGuardUserRelatedByUserFrom(), '@sf_social_user?username=' . $invite->getSfGuardUserRelatedByUserFrom()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>
