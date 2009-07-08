<h2><?php echo __('Send a contact request', null, 'sfSocial') ?></h2>

<div id="send_request">
  <form action="<?php echo url_for('@sf_social_contact_send_request') ?>" method="post">
    <ul class="form">
      <?php echo $form ?>
      <li class="buttons">
        <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_contact_list', 'class=cancel') ?>
        <input type="submit" value="<?php echo __('send', null, 'sfSocial') ?>" />
      </li>
    </ul>
  </form>
</div>