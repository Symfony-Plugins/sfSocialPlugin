<h2><?php echo __('Invite to event') ?> &quot;<?php echo $event->getTitle() ?>&quot;</h2>

<?php if ($form->isValid()): ?>
<?php echo __('User invited') ?>
<?php endif ?>

<div id="event_invite">
<form action="<?php echo url_for('@sf_social_event_invite?id=' . $event->getId()) ?>" method="post">
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

<hr />

<?php echo link_to(__('Back to event'), '@sf_social_event?id=' . $event->getId()) ?>