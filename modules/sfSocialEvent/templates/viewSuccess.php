<h2><?php echo __('Event &quot;%1%&quot;', array('%1%' => $event->getTitle()), 'sfSocial') ?></h2>
<?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
</div>
<?php endif ?>

<h3><?php echo __('When', null, 'sfSocial') ?>: <?php echo $event->getWhen() ?></h3>

<div id="event_body">
  <?php echo $event->getDescription() ?>
</div>

<?php if ($event->isAdmin($_user)): ?>
<div id="event_edit">
  <?php echo link_to(__('Edit event', null, 'sfSocial'), '@sf_social_event_edit?id=' . $event->getId()) ?>
</div>
<?php endif ?>

<div id="event_confirm">
<form action="<?php echo url_for('@sf_social_event?id=' . $event->getId()) ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <input type="submit" value="<?php echo __('confirm', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
</div>

<?php if ($event->isAdmin($_user)): ?>
<h3><?php echo __('Invite', null, 'sfSocial') ?>:</h3>
<div id="event_invite">
<form action="<?php echo url_for('@sf_social_event_invite?id=' . $event->getId()) ?>" method="post">
  <ul class="form">
    <?php echo $form2 ?>
    <li class="buttons">
      <input type="submit" value="<?php echo __('invite', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
</div>
<?php endif ?>

<h3><?php echo __('Invited users', null, 'sfSocial') ?>:</h3>
<?php if (null === $invited = $event->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId()): ?>
<?php echo __('No invited users', null, 'sfSocial') ?>
<?php else: ?>
<ul id="invited">
<?php foreach ($event->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId() as $invite): ?>
  <li>
    <?php $_user = $invite->getsfGuardUserRelatedByUserId() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@sf_social_user?username=' . $_user) ?>
    <div><?php echo $invite->getReplied() ? __($invite->getReply(), null, 'sfSocial') : __('awaiting reply', null, 'sfSocial') ?></div>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>

<hr />

<?php if ($event->getEnd() > time()): ?>
<?php echo link_to(__('Back to list'), '@sf_social_event_pastlist', null, 'sfSocial') ?>
<?php else: ?>
<?php echo link_to(__('Back to list'), '@sf_social_event_list', null, 'sfSocial') ?>
<?php endif ?>
