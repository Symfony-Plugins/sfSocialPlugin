<h2>
  <?php echo __('Message sent from you to') ?>:
  <?php foreach ($rcpts as $rcpt): ?>
  <u><?php echo $rcpt->getsfGuardUser()->getUsername() ?></u> <!-- TODO user link -->
  <?php endforeach ?>
</h2>
<h3><?php echo __('Date') ?>: <?php echo $message->getCreatedAt() ?></h3>
<h3><?php echo __('Subject') ?>: <?php echo $message->getSubject() ?></h3>
<blockquote>
  <?php echo $message->getText() ?>
</blockquote>
<hr />
<?php echo link_to(__('Back to list'), '@sf_social_message_sentlist') ?>