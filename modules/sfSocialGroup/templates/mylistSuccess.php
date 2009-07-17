<?php use_helper('Text') ?>
<h2><?php echo __('Your groups', null, 'sfSocial') ?></h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
</div>
<?php endif ?>

<?php if (empty($groups)): ?>
<p>
  <?php echo __('You\'re not member of any group', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($groups as $group): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <strong><?php echo link_to($group->getTitle(), '@sf_social_group?id=' . $group->getId()) ?></strong>
    <div class="descr">
      <?php echo link_to(truncate_text($group->getDescription(), 50), '@sf_social_group?id=' . $group->getId()) ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php endif ?>

<?php echo link_to(__('All groups', null, 'sfSocial'), '@sf_social_group_list') ?> |
<?php echo link_to(__('Create a new group', null, 'sfSocial'), '@sf_social_group_new') ?>
