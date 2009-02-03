<h2><?php echo __('Message from') ?> <?php echo link_to($message->getsfGuardUser(), '@sf_social_user?username=' . $message->getsfGuardUser()) ?></u></h2> <!-- TODO user link -->
<h3><?php echo __('Date') ?>: <?php echo $message->getCreatedAt() ?></h3>
<h3><?php echo __('Subject') ?>: <?php echo $message->getSubject() ?></h3>
<blockquote>
  <?php echo $message->getText() ?>
</blockquote>
<hr />
<?php echo link_to(__('Reply'), '@sf_social_message_new?reply_to=' . $message->getId()) ?> |
<?php echo link_to(__('Back to list'), '@sf_social_message_list') ?>