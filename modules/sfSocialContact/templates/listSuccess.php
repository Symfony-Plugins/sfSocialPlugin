<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No contacts') ?></h2>
<?php else: ?>
<h2><?php echo __('Contacts list') ?></h2>
<ul>
<?php foreach ($pager->getResults() as $contact): ?>
  <li>
    <?php echo $contact->getsfGuardUserRelatedByUserFrom()->getUsername() ?>
		: <?php echo link_to(__('Remove'), '@sf_social_contact_delete?id=' . $contact->getId()) ?>
  </li>
<?php endforeach ?>
</ul>
<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_contact_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>
<?php echo link_to(__('List of requests'), '@sf_social_contact_requests') ?> | 
<?php echo link_to(__('Send request'), '@sf_social_contact_send_request') ?>