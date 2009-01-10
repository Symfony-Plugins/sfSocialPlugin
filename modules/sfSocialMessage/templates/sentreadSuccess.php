<h2><?php echo __('Message to') ?> <?php echo $message->getsfGuardUserRelatedByUserTo()->getUsername() ?></h2>
<h3><?php echo __('Date') ?>: <?php echo $message->getCreatedAt() ?></h3>
<h3><?php echo __('Subject') ?>: <?php echo $message->getSubject() ?></h3>
<div id="message_body">
  <?php echo $message->getText() ?>
</div>
<hr />
<?php echo link_to(__('Back to list'), '@sf_social_message_sentlist') ?>