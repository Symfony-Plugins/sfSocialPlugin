<h2><?php echo __('Groups') ?></h2>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No groups yet') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $group): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php echo link_to($group->getTitle(), '@sf_social_group?id=' . $group->getId()) ?>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_group_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>

<?php echo link_to(__('Create a new group'), '@sf_social_group_new') ?>