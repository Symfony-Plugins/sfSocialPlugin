<?php use_helper('Date') ?>
<h2><?php echo $message->getSubject() ?></h2>

<?php $_user = $message->getsfGuardUser() ?>
<?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user), '@sf_social_user?username=' . $_user) ?>

<?php echo format_datetime($message->getCreatedAt()) ?>

<blockquote>
  <?php echo $message->getText() ?>
</blockquote>

<hr />
<?php echo link_to(__('Reply', null, 'sfSocial'), '@sf_social_message_new?reply_to=' . $message->getId()) ?> |
<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_message_list') ?>