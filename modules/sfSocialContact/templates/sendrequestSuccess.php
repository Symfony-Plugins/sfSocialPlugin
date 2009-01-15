<div id="send_request">
<form action="<?php echo url_for('@sf_social_contact_send_request') ?>" method="post">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
</div>
<?php echo link_to(__('Return to list'), '@sf_social_contact_list') ?>