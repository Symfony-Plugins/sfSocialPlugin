<h2>
  <?php echo __('Message sent from you to', null, 'sfSocial') ?>:
  <?php foreach ($rcpts as $rcpt): ?>
  <?php echo link_to($rcpt->getSfGuardUser(), '@sf_social_user?username=' . $rcpt->getSfGuardUser()) ?>
  <?php endforeach ?>
</h2>
<h3><?php echo __('Date', null, 'sfSocial') ?>: <?php echo $message->getCreatedAt() ?></h3>
<h3><?php echo __('Subject', null, 'sfSocial') ?>: <?php echo $message->getSubject() ?></h3>
<blockquote>
  <?php echo $message->getText() ?>
</blockquote>

<hr />
<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_message_sentlist') ?>