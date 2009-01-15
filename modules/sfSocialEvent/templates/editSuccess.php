<h2><?php echo __('Edit event ') ?> &quot;<?php echo $event->getTitle() ?>&quot;</h2>
<form action="<?php echo url_for('@sf_social_event_edit?id=' . $event->getId()) ?>" method="post">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
