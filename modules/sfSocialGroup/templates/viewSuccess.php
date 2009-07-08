<h2><?php echo __('Group &quot;%1%&quot;', array('%1%' => $group->getTitle()), 'sfSocial') ?></h2>
<?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
</div>
<?php endif ?>

<div id="group_body">
  <?php echo $group->getDescription() ?>
</div>

<?php if ($group->isAdmin($_user)): ?>
<div id="group_edit">
  <?php echo link_to(__('Edit group', null, 'sfSocial'), '@sf_social_group_edit?id=' . $group->getId()) ?>
</div>
<?php endif ?>

<?php if (!$group->isMember($_user)): ?>
<div id="group_confirm">
<?php if ($group->isInvited($_user)): ?>
  <?php echo link_to(__('Accept invite', null, 'sfSocial'), '@sf_social_group_accept?id=' . $group->getInvite($_user)->getId()) ?>
  <?php echo link_to(__('Deny invite', null, 'sfSocial'), '@sf_social_group_deny?id=' . $group->getInvite($_user)->getId()) ?>
<?php else: ?>
  <?php echo link_to(__('Join this group', null, 'sfSocial'), '@sf_social_group_join?id=' . $group->getId()) ?>
<?php endif ?>
</div>
<?php endif ?>

<?php if ($group->isMember($_user)): ?>
<h3><?php echo __('Invite', null, 'sfSocial') ?>:</h3>
<div id="group_invite">
<form action="<?php echo url_for('@sf_social_group_invite?id=' . $group->getId()) ?>" method="post">
  <ul class="form">
    <?php echo $form ?>
    <li class="buttons">
      <input type="submit" value="<?php echo __('invite', null, 'sfSocial') ?>" />
    </li>
  </ul>
</form>
</div>
<?php endif ?>

<h3><?php echo __('Invited users', null, 'sfSocial') ?>:</h3>
<?php if (null === $invited = $group->getInvitedUsers()): ?>
<?php echo __('No invited users', null, 'sfSocial') ?>
<?php else: ?>
<ul id="invited">
<?php foreach ($invited as $invite): ?>
  <li>
    <?php $_user = $invite->getsfGuardUserRelatedByUserId() instanceof sfGuardUser ? $invite->getsfGuardUserRelatedByUserId() : $invite->getsfGuardUserRelatedByUserId()->getRawValue() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'title=' . $_user), '@sf_social_user?username=' . $_user) ?>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>

<h3><?php echo __('Members', null, 'sfSocial') ?>:</h3>
<?php if (null === $members = $group->getsfSocialGroupInvitesJoinsfGuardUserRelatedByUserId()): ?>
<?php echo __('No members', null, 'sfSocial') ?>
<?php else: ?>
<ul id="invited">
<?php foreach ($group->getsfSocialGroupUsersJoinsfGuardUser() as $groupUser): ?>
  <li>
    <?php echo link_to(image_tag($groupUser->getsfGuardUser()->getThumb(), 'title=' . $groupUser->getsfGuardUser()), '@sf_social_user?username=' . $groupUser->getsfGuardUser()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>

<hr />

<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_group_list') ?>