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

<h3><?php echo __('Will partecipate', null, 'sfSocial') ?>:</h3>
<?php if (count($confirmed = $event->getConfirmedUsers()) > 0): ?>
<ul id="confirmed" class="event">
<?php foreach ($confirmed as $eventUser): ?>
  <li>
    <?php $cUser = $eventUser->getsfGuardUser() ?>
    <?php echo link_to(image_tag($cUser->getThumb(), 'alt=' . $cUser . ' title=' . $cUser . ' class=left'), '@sf_social_user?username=' . $cUser) ?>
  </li>
<?php endforeach ?>
</ul>
<?php else: ?>
<?php echo __('None yet', null, 'sfSocial') ?>
<?php endif ?>

<h3><?php echo __('Maybe will partecipate', null, 'sfSocial') ?>:</h3>
<?php if (count($maybes = $event->getMaybeUsers()) > 0): ?>
<ul id="maybe" class="event">
<?php foreach ($maybes as $eventUser): ?>
  <li>
    <?php $cUser = $eventUser->getsfGuardUser() ?>
    <?php echo link_to(image_tag($cUser->getThumb(), 'alt=' . $cUser . ' title=' . $cUser . ' class=left'), '@sf_social_user?username=' . $cUser) ?>
  </li>
<?php endforeach ?>
</ul>
<?php else: ?>
<?php echo __('None yet', null, 'sfSocial') ?>
<?php endif ?>

<h3><?php echo __('Will not partecipate', null, 'sfSocial') ?>:</h3>
<?php if (count($nots = $event->getNoUsers()) > 0): ?>
<ul id="not" class="event">
<?php foreach ($nots as $eventUser): ?>
  <li>
    <?php $cUser = $eventUser->getsfGuardUser() ?>
    <?php echo link_to(image_tag($cUser->getThumb(), 'alt=' . $cUser . ' title=' . $cUser . ' class=left'), '@sf_social_user?username=' . $cUser) ?>
  </li>
<?php endforeach ?>
</ul>
<?php else: ?>
<?php echo __('None yet', null, 'sfSocial') ?>
<?php endif ?>

<h3><?php echo __('Awaiting reply', null, 'sfSocial') ?>:</h3>
<?php if (count($invited = $event->getAwaitingReplyUsers()) > 0): ?>
<ul id="invited" class="event">
<?php foreach ($invited as $invite): ?>
  <li>
    <?php $_user = $invite->getsfGuardUserRelatedByUserId() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@sf_social_user?username=' . $_user) ?>
  </li>
<?php endforeach ?>
</ul>
<?php else: ?>
<?php echo __('None yet', null, 'sfSocial') ?>
<?php endif ?>

<hr />

<?php if ($event->getEnd() > time()): ?>
<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_event_pastlist') ?>
<?php else: ?>
<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_event_list') ?>
<?php endif ?>
