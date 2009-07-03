<h2><?php echo __('Contacts list') ?></h2>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No contacts') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $contact): ?>
  <li>
    <?php echo link_to($contact->getsfGuardUserRelatedByUserFrom()->getUsername(), '@sf_social_user?username=' . $contact->getsfGuardUserRelatedByUserFrom()->getUsername()) ?>
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

<?php echo link_to(__('List of received requests'), '@sf_social_contact_requests') ?> |
<?php echo link_to(__('List of sent requests'), '@sf_social_contact_sentrequests') ?> |
<?php echo link_to(__('Send request'), '@sf_social_contact_send_request') ?>