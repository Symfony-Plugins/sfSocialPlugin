<h2><?php echo __('Event') ?> &quot;<?php echo $event->getTitle() ?>&quot;</h2>
<?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif ?>

<h3><?php echo __('When') ?>: <?php echo $event->getWhen() ?></h3>

<div id="event_body">
  <?php echo $event->getDescription() ?>
</div>

<?php if ($event->isAdmin($_user)): ?>
<div id="event_edit">
  <?php echo link_to(__('Edit event'), '@sf_social_event_edit?id=' . $event->getId()) ?>
</div>
<?php endif ?>

<div id="event_confirm">
<form action="<?php echo url_for('@sf_social_event?id=' . $event->getId()) ?>" method="post">
  <ul id="form">
    <?php echo $form ?>
    <li class="buttons">
      <input type="submit" value="<?php echo __('confirm') ?>" />
    </li>
  </ul>
</form>
</div>

<?php if ($event->isAdmin($_user)): ?>
<h3><?php echo __('Invite:') ?></h3>
<div id="event_invite">
<form action="<?php echo url_for('@sf_social_event_invite?id=' . $event->getId()) ?>" method="post">
  <ul id="form">
    <?php echo $form2 ?>
    <li class="buttons">
        <input type="submit" value="<?php echo __('invite') ?>" />
    </li>
  </ul>
</form>
</div>
<?php endif ?>

<h3><?php echo __('Invited users:') ?></h3>
<?php if (null === $invited = $event->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId()): ?>
<?php echo __('No invited users') ?>
<?php else: ?>
<ul id="invited">
<?php foreach ($event->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId() as $invite): ?>
  <li>
    <?php echo link_to($invite->getsfGuardUserRelatedByUserId(), '@sf_social_user?username=' . $invite->getsfGuardUserRelatedByUserId()) ?>:
    <?php echo $invite->getReplied() ? __($invite->getReply()) : __('awaiting reply') ?>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>

<hr />

<?php if ($event->getEnd() > time()): ?>
<?php echo link_to(__('Back to list'), '@sf_social_event_pastlist') ?>
<?php else: ?>
<?php echo link_to(__('Back to list'), '@sf_social_event_list') ?>
<?php endif ?>