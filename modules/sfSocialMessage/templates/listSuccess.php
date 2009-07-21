<?php use_helper('Date', 'Text') ?>
<h2><?php echo __('Messages received', null, 'sfSocial') ?></h2>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No messages received yet', null, 'sfSocial') ?>
</p>
<?php else: ?>

<?php if ($unread > 0): ?>
<?php echo $unread ?> <?php echo __('unread messages', null, 'sfSocial') ?>
<?php endif ?>

<ul id="list">
<?php foreach ($pager->getResults() as $rcpt): ?>
<?php $message = $rcpt->getSfSocialMessage() ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?> <?php echo $rcpt->getIsRead() ? 'read' : 'unread' ?>">
    <div class="date"><?php echo format_datetime($message->getCreatedAt()) ?></div>
    <div class="subject">
      <?php echo link_to($message->getSubject(), '@sf_social_message_read?id=' . $message->getId()) ?>
    </div>
    <div class="text">
      <?php echo link_to(truncate_text($message->getText(), 50), '@sf_social_message_read?id=' . $message->getId()) ?>
    </div>
    <div class="from">
      <?php echo link_to(image_tag($message->getsfGuardUser()->getThumb(), 'alt=' . $message->getsfGuardUser() . ' title=' . $message->getsfGuardUser()), '@sf_social_user?username=' . $message->getsfGuardUser()) ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<div id="pager">
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_message_list?page=' . $page) ?>
<?php endforeach ?>
</div>
<?php endif ?>

<?php endif ?>

<?php echo link_to(__('Sent messages', null, 'sfSocial'), '@sf_social_message_sentlist') ?> |
<?php echo link_to(__('Compose a new message', null, 'sfSocial'), '@sf_social_message_new') ?>