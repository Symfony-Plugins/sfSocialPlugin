<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No messages received yet') ?></h2>
<?php else: ?>
<h2><?php echo __('Messages received') ?></h2>
<?php if ($unread > 0): ?>
<?php echo $unread ?> <?php echo __('unread messages') ?>
<?php endif ?>
<ul>
<?php foreach ($pager->getResults() as $rcpt): ?>
<?php $message = $rcpt->getSfSocialMessage() ?>
  <li class="<?php echo $rcpt->getRead() ? 'read' : 'unread' ?>">
    <?php echo $message->getCreatedAt() ?>
    * <?php echo link_to($message->getSubject(), '@sf_social_message_read?id=' . $message->getId()) ?>
    - <?php echo __('from') ?> <?php echo link_to($message->getsfGuardUser(), '@sf_social_user?username=' . $message->getsfGuardUser()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_message_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>
<?php echo link_to(__('Sent messages'), '@sf_social_message_sentlist') ?> |
<?php echo link_to(__('Compose a new message'), '@sf_social_message_new') ?>