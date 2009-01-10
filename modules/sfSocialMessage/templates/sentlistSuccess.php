<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No messages sent yet') ?></h2>
<?php else: ?>
<h2><?php echo __('Messages sent') ?></h2>
<ul>
<?php foreach ($pager->getResults() as $message): ?>
  <li class="<?php echo $message->getRead() ? 'read' : 'unread' ?>">
    <?php echo $message->getCreatedAt() ?>
    * <?php echo link_to($message->getSubject(), '@sf_social_message_sentread?id=' . $message->getId()) ?>
    - <?php echo __('to') ?> <u><?php echo $message->getsfGuardUserRelatedByUserTo()->getUsername() ?></u> <!-- TODO user link -->
  </li>
<?php endforeach ?>
</ul>
<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_message_sentlist?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>