<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No events yet') ?></h2>
<?php else: ?>
<h2><?php echo __('Events') ?></h2>
<ul>
<?php foreach ($pager->getResults() as $event): ?>
  <li>
    <?php echo link_to($event->getTitle(), '@sf_social_event_view?id=' . $event->getId()) ?>
    <?php echo $event->getWhen() ?>
    <?php echo __('in') ?> <?php echo $event->getLocation() ?>
    - <?php echo __('by') ?> <u><?php echo $event->getsfGuardUser()->getUsername() ?></u> <!-- TODO user link -->
  </li>
<?php endforeach ?>
</ul>
<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_event_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>