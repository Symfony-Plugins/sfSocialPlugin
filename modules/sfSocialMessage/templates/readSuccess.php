<h2><?php echo $message->getSubject() ?></h2>
<?php echo link_to($message->getsfGuardUser(), '@sf_social_user?username=' . $message->getsfGuardUser(), 'class=user') ?>
<?php echo $message->getCreatedAt() ?>

<blockquote>
  <?php echo $message->getText() ?>
</blockquote>
<hr />
<?php echo link_to(__('Reply'), '@sf_social_message_new?reply_to=' . $message->getId()) ?> |
<?php echo link_to(__('Back to list'), '@sf_social_message_list') ?>