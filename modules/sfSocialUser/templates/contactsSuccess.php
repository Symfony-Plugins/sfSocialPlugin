<h2><?php echo __('Contacts of %1%', array('%1%' => $pageUser), 'sfSocial') ?></h2>

<?php echo link_to(__('Back to %1%\'s profile', array('%1%' => $pageUser), 'sfSocial'), '@sf_social_user?username=' . $pageUser) ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No contacts', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $contact): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php $_user = $contact->getsfGuardUserRelatedByUserTo() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@sf_social_user?username=' . $_user) ?>
    <div><?php echo link_to($_user, '@sf_social_user?username=' . $_user) ?></div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_contact_list?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>

<?php endif ?>