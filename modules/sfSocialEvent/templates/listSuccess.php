<h2><?php echo __('Events', null, 'sfSocial') ?></h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No events yet', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $event): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <strong><?php echo link_to($event->getTitle(), '@sf_social_event?id=' . $event->getId()) ?></strong>
    <div>
      <?php echo $event->getWhen() ?>
      <?php echo __('in', null, 'sfSocial') ?> <?php echo $event->getLocation() ?>
      - <?php echo __('by', null, 'sfSocial') ?> <?php echo link_to($event->getsfGuardUser(), '@sf_social_user?username=' . $event->getsfGuardUser()) ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_event_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>

<?php endif ?>

<?php echo link_to(__('Create a new event', null, 'sfSocial'), '@sf_social_event_new') ?>