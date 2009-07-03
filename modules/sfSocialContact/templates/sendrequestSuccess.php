<div id="send_request">
  <form action="<?php echo url_for('@sf_social_contact_send_request') ?>" method="post">
    <ul id="form">
      <?php echo $form ?>
      <li class="buttons">
        <?php echo link_to(__('cancel'), '@sf_social_contact_list', 'class=cancel') ?>
        <input type="submit" value="<?php echo __('send') ?>" />
      </li>
    </ul>
  </form>
</div>