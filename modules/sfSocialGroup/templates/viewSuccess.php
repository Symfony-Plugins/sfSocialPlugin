<h2><?php echo __('Group &quot;%1%&quot;', array('%1%' => $group->getTitle()), 'sfSocial') ?></h2>
<?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php if ($sf_user->hasFlash('nr')): ?>
  <?php echo __($sf_user->getFlash('notice'), array('%1%' => $sf_user->getFlash('nr')), 'sfSocial') ?>
  <?php else: ?>
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
  <?php endif ?>
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
  <form id="invites" action="<?php echo url_for('@sf_social_group_invite?id=' . $group->getId()) ?>" method="post">
    <?php echo $form['user_id']->renderError() ?>
    <?php echo $form['user_id']->renderLabel() ?>
    <?php echo $form['user_id'] ?>
    <input type="submit" value="<?php echo __('invite', null, 'sfSocial') ?>" />
    <?php echo $form->renderHiddenFields() ?>
  </form>
</div>
<?php endif ?>

<h3><?php echo __('Invited users', null, 'sfSocial') ?>:</h3>
<?php if (null === $invited = $group->getInvitedUsers()): ?>
<?php echo __('No invited users', null, 'sfSocial') ?>
<?php else: ?>
<div class="contacts">
  <ul id="invited">
  <?php foreach ($invited as $invite): ?>
    <li>
      <?php $_user = $invite->getsfGuardUserRelatedByUserId() instanceof sfGuardUser ? $invite->getsfGuardUserRelatedByUserId() : $invite->getsfGuardUserRelatedByUserId()->getRawValue() ?>
      <?php echo link_to(image_tag($_user->getThumb(), 'title=' . $_user . ' alt=' . $_user), '@sf_social_user?username=' . $_user) ?>
    </li>
  <?php endforeach ?>
  </ul>
  <hr />
</div>
<?php endif ?>

<h3><?php echo __('Members', null, 'sfSocial') ?>:</h3>
<?php if (null === $members = $group->getsfSocialGroupUsers()): ?>
<?php echo __('No members', null, 'sfSocial') ?>
<?php else: ?>
<div class="contacts">
  <ul id="members">
  <?php foreach ($members as $groupUser): ?>
    <li>
      <?php $_groupUser = $groupUser instanceof sfSocialGroupUser ? $groupUser : $groupUser->getRawValue() ?>
      <?php echo link_to(image_tag($_groupUser->getsfGuardUser()->getThumb(), 'title=' . $_groupUser->getsfGuardUser() . ' alt=' . $_groupUser->getsfGuardUser()), '@sf_social_user?username=' . $_groupUser->getsfGuardUser()) ?>
    </li>
  <?php endforeach ?>
  </ul>
  <hr />
</div>
<?php endif ?>

<hr />

<?php echo link_to(__('Back to list', null, 'sfSocial'), '@sf_social_group_list') ?>
