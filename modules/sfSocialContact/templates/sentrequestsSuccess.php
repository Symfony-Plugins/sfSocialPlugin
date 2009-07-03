<h2><?php echo __('List of sent contact requests') ?></h2>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No request') ?>
</p>
<?php else: ?>

<ul>
<?php foreach ($pager->getResults() as $request): ?>
  <li>
		<?php echo __('to') ?>
    <?php echo link_to($request->getsfGuardUserRelatedByUserTo()->getUsername(), '@sf_social_user?username=' . $request->getsfGuardUserRelatedByUserTo()->getUsername()) ?>
    (<?php echo link_to(__('cancel'), '@sf_social_contact_cancel_request?id=' . $request->getId()) ?>)
    <br /><?php echo $request->getMessage() ?>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_contact_requests?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>
<?php echo link_to(__('Return to list'), '@sf_social_contact_list') ?>