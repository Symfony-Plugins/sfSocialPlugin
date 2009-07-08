<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No invite received yet', null, 'sfSocial') ?></h2>
<?php else: ?>
<h2><?php echo __('Invites received for events', null, 'sfSocial') ?></h2>

<ul id="list">
<?php foreach ($pager->getResults() as $invite): ?>
<?php $event = $invite->getSfSocialEvent() ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php echo link_to($event, '@sf_social_event?id=' . $event->getId()) ?>
    <?php echo $event->getWhen() ?>
    <?php echo __('in', null, 'sfSocial') ?> <?php echo $event->getLocation() ?>
    - <?php echo __('from', null, 'sfSocial') ?> <?php echo link_to($invite->getSfGuardUserRelatedByUserFrom(), '@sf_social_user?username=' . $invite->getSfGuardUserRelatedByUserFrom()) ?>
  </li>
<?php endforeach ?>
</ul>

<?php endif ?>
