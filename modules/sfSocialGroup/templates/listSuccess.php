<?php use_helper('Text') ?>
<h2><?php echo __('Groups', null, 'sfSocial') ?></h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No groups yet', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $group): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <strong><?php echo link_to($group->getTitle(), 'sf_social_group', $group) ?></strong>
    <div class="descr">
      <?php echo link_to(truncate_text($group->getDescription(), 50), 'sf_social_group', $group) ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_group_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>

<?php endif ?>

<?php echo link_to(__('Your groups', null, 'sfSocial'), '@sf_social_group_mylist') ?> |
<?php echo link_to(__('Create a new group', null, 'sfSocial'), '@sf_social_group_new') ?>
