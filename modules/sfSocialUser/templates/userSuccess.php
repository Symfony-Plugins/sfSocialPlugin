<h2><?php echo $pageUser ?></h2>
<?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>
<?php /* escaping strategy safety */ $_pageUser = $pageUser instanceof sfGuardUser ? $pageUser : $pageUser->getRawValue() ?>

<?php if ($profile->getPicture()): ?>
<div class="pic">
  <?php echo image_tag(sfConfig::get('app_sf_social_pic_path', '/uploads/sf_social_pics/') . $profile->getPicture()) ?>
</div>
<?php endif ?>

<?php if ($pageUser->getId() == $user->getId()): ?>
<?php echo  __('it\'s you!', null, 'sfSocial') ?>
<?php elseif ($pageUser->hasContact($_user)): ?>
<?php echo link_to($pageUser . ' ' . __('is your contact', null, 'sfSocial'), '@sf_social_contact_list') ?>
<?php elseif ($user->hasContactRequest($_pageUser)): ?>
<?php echo link_to(__('A contact request is pending', null, 'sfSocial'), '@sf_social_contact_sentrequests') ?>
<?php elseif ($pageUser->hasContactRequest($_user)): ?>
<?php echo link_to(__('A contact request is pending', null, 'sfSocial'), '@sf_social_contact_requests') ?>
<?php else: ?>
<?php echo link_to(__('Add %1% to your contacts', array('%1%' => $pageUser), 'sfSocial'), '@sf_social_contact_send_request?to=' . $pageUser) ?>
<?php endif ?>

<ul class="attrs">
  <li><?php echo __('Name', null, 'sfSocial') ?>: <?php echo $profile->getFirstName() ?> <?php echo $profile->getLastName() ?></li>
  <li><?php echo __('Birthday', null, 'sfSocial') ?>: <?php echo $profile->getBirthday() ?></li>
  <li><?php echo __('Sex', null, 'sfSocial') ?>: <?php echo $profile->getSex() ?></li>
  <li><?php echo __('Location', null, 'sfSocial') ?>: <?php echo $profile->getLocation() ?></li>
</ul>

<?php $countContacts = $pageUser->countContacts() ?>
<?php $contacts = $pageUser->getContacts(4) ?>
<?php if ($countContacts > 0): ?>
<div id="user_contacts">
  <strong><?php echo format_number_choice('[1]1 contact[2,+Inf]%1% contacts', array('%1%' => $countContacts), $countContacts, 'sfSocial') ?></strong>
  <ul>
  <?php foreach ($contacts as $contact): ?>
    <li>
      <?php echo link_to(image_tag($contact->getThumb(), 'title=' . $contact), '@sf_social_user?username=' . $contact) ?>
    </li>
  <?php endforeach ?>
  </ul>
  <hr />
  <?php if ($countContacts > count($contacts)): ?>
  <?php echo link_to(__('See all contacts', null, 'sfSocial'), '@sf_social_user_contacts?username=' . $user) ?>
  <?php endif ?>
</div>
<?php endif ?>

<?php $groups = $pageUser->getsfSocialGroups() ?>
<?php if (count($groups) > 0): ?>
<div id="user_groups">
  <strong><?php echo __('member of groups', null, 'sfSocial') ?>:</strong>
  <ul>
  <?php foreach ($groups as $group): ?>
    <li><?php echo link_to($group, '@sf_social_group?id=' . $group->getId()) ?></li>
  <?php endforeach ?>
  </ul>
  </div>
<?php endif ?>

<?php if ($pageUser->getId() == $user->getId()): ?>
<?php echo link_to(__('Edit profile', null, 'sfSocial'), '@sf_social_user_edit?username=' . $user) ?>
<?php endif ?>