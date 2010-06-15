<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No invite received yet', null, 'sfSocial') ?></h2>
<?php else: ?>
<h2><?php echo __('Invites received for events', null, 'sfSocial') ?></h2>

<ul id="list">
<?php foreach ($pager->getResults() as $invite): ?>
<?php $event = $invite->getEvent() ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php echo link_to($event, 'sf_social_event', $event) ?>
    <?php echo $event->getWhen() ?>
    <?php echo __('in', null, 'sfSocial') ?> <?php echo $event->getLocation() ?>
    - <?php echo __('from', null, 'sfSocial') ?> <?php echo link_to($invite->getFrom(), 'sf_social_user', $invite->getFrom()) ?>
  </li>
<?php endforeach ?>
</ul>

<?php endif ?>
