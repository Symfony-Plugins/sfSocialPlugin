<h2><?php echo __('New event ') ?></h2>
<form action="<?php echo url_for('@sf_social_event_new') ?>" method="post">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
