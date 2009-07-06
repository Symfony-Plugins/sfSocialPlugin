<h2><?php echo __('Group') ?> &quot;<?php echo $group->getTitle() ?>&quot;</h2>
<?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif ?>

<div id="group_body">
  <?php echo $group->getDescription() ?>
</div>

<?php if ($group->isAdmin($_user)): ?>
<div id="group_edit">
  <?php echo link_to(__('Edit group'), '@sf_social_group_edit?id=' . $group->getId()) ?>
</div>
<?php endif ?>

<?php if (!$group->isMember($_user)): ?>
<div id="group_confirm">
<?php if ($group->isInvited($_user)): ?>
  <?php echo link_to(__('Accept invite'), '@sf_social_group_accept?id=' . $group->getInvite($_user)->getId()) ?>
  <?php echo link_to(__('Deny invite'), '@sf_social_group_deny?id=' . $group->getInvite($_user)->getId()) ?>
<?php else: ?>
  <?php echo link_to(__('Join this group'), '@sf_social_group_join?id=' . $group->getId()) ?>
<?php endif ?>
</div>
<?php endif ?>

<?php if ($group->isMember($_user)): ?>
<h3><?php echo __('Invite:') ?></h3>
<div id="group_invite">
<form action="<?php echo url_for('@sf_social_group_invite?id=' . $group->getId()) ?>" method="post">
  <ul id="form">
    <?php echo $form ?>
    <li class="buttons">
      <input type="submit" value="<?php echo __('invite') ?>" />
    </li>
  </ul>
</form>
</div>
<?php endif ?>

<h3><?php echo __('Invited users:') ?></h3>
<?php if (null === $invited = $group->getInvitedUsers()): ?>
<?php echo __('No invited users') ?>
<?php else: ?>
<ul id="invited">
<?php foreach ($invited as $invite): ?>
  <li>
    <?php echo link_to($invite->getsfGuardUserRelatedByUserId(), '@sf_social_user?username=' . $invite->getsfGuardUserRelatedByUserId()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>

<h3><?php echo __('Members:') ?></h3>
<?php if (null === $members = $group->getsfSocialGroupInvitesJoinsfGuardUserRelatedByUserId()): ?>
<?php echo __('No invited users') ?>
<?php else: ?>
<ul id="invited">
<?php foreach ($group->getsfSocialGroupUsersJoinsfGuardUser() as $groupUser): ?>
  <li>
    <?php echo link_to($groupUser->getsfGuardUser(), '@sf_social_user?username=' . $groupUser->getsfGuardUser()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php endif ?>

<hr />

<?php echo link_to(__('Back to list'), '@sf_social_group_list') ?>