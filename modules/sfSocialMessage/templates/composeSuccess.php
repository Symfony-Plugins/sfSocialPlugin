<form action="<?php echo url_for('@sf_social_message_new') ?>" method="post">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" value="<?php echo __('send') ?>" />
      </td>
    </tr>
  </table>
</form>
<?php echo link_to(__('cancel'), '@sf_social_message_list') ?>