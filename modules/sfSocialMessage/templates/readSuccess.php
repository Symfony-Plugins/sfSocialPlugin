<h2><?php echo __('Message from') ?> <u><?php echo $message->getsfGuardUserRelatedByUserFrom()->getUsername() ?></u></h2> <!-- TODO user link -->
<h3><?php echo __('Date') ?>: <?php echo $message->getCreatedAt() ?></h3>
<h3><?php echo __('Subject') ?>: <?php echo $message->getSubject() ?></h3>
<div id="message_body">
  <?php echo $message->getText() ?>
</div>
<hr />
<?php echo link_to(__('Reply'), '@sf_social_message_new?reply_to=' . $message->getId()) ?> |
<?php echo link_to(__('Back to list'), '@sf_social_message_list') ?>