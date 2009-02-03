<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No sent messages yet') ?></h2>
<?php else: ?>
<h2><?php echo __('Sent messages') ?></h2>
<ul>
<?php foreach ($pager->getResults() as $rcpt): ?>
<?php $message = $rcpt->getSfSocialMessage() ?>
  <li class="read">
    <?php echo $message->getCreatedAt() ?>
    * <?php echo link_to($message->getSubject(), '@sf_social_message_sentread?id=' . $message->getId()) ?>
    <?php echo __('to') ?> <?php echo link_to($rcpt->getSfGuardUser(), '@sf_social_user?username=' . $rcpt->getSfGuardUser()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_message_sentlist?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>
<?php echo link_to(__('Received messages'), '@sf_social_message_list') ?>