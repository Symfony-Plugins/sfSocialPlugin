<h2><?php echo __('Contacts list', null, 'sfSocial') ?></h2>

<?php if ($sf_user->getFlash('notice')): ?>
<div class="notice">
  <?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No contacts', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $contact): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php $_user = $contact->getsfGuardUserRelatedByUserFrom() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@sf_social_user?username=' . $_user) ?>
		<div><?php echo __('added on', null, 'sfSocial') ?> <?php echo $contact->getCreatedAt() ?></div>
    <div><?php echo link_to(__('Remove', null, 'sfSocial'), '@sf_social_contact_delete?id=' . $contact->getId()) ?></div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_contact_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>

<?php endif ?>

<?php echo link_to(__('List of received requests', null, 'sfSocial'), '@sf_social_contact_requests') ?> |
<?php echo link_to(__('List of sent requests', null, 'sfSocial'), '@sf_social_contact_sentrequests') ?> |
<?php echo link_to(__('Send request', null, 'sfSocial'), '@sf_social_contact_send_request') ?>