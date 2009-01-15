<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No request') ?></h2>
<?php else: ?>
<h2><?php echo __('List requests contact') ?></h2>
<ul>
<?php foreach ($pager->getResults() as $request): ?>
  <li>
		<?php echo $request->getMessage() ?> <?php echo __('by') ?> <?php echo $request->getsfGuardUserRelatedByUserFrom()->getUsername() ?>
		* <?php echo link_to(__('Accept'), '@sf_social_contact_accept_request?id=' . $request->getId()) ?> / <?php echo link_to(__('Deny'), '@sf_social_contact_deny_request?id=' . $request->getId()) ?>
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