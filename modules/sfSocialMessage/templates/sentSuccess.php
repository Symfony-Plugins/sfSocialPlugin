<h2>OK</h2>
<?php echo __('Message successfully sent to', null, 'sfSocial') ?>:
<ul>
<?php foreach ($to as $user): ?>
  <li><?php echo $user->getUsername() ?></li>
<?php endforeach ?>
</ul>
<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_message_list') ?>