<?php use_helper('Date') ?>
<h2><?php echo __('List of sent contact requests', null, 'sfSocial') ?></h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice'), null, 'sfSocial') ?>
</div>
<?php endif ?>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No request', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $request): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php $_user = $request->getsfGuardUserRelatedByUserTo() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@sf_social_user?username=' . $_user) ?>
    <div>
      <?php echo link_to($_user, '@sf_social_user?username=' . $_user) ?>,
      <?php echo __('sent %1% ago', array('%1%' => time_ago_in_words($request->getCreatedAt('U'))), 'sfSocial') ?>
    </div>
    <div class="req_message"><?php echo $request->getMessage() ?></div>
    <div>
      <?php echo link_to(__('cancel', null, 'sfSocial'), '@sf_social_contact_cancel_request?id=' . $request->getId(), 'confirm=' . __('cancel', null, 'sfSocial') . '?') ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_contact_requests?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>

<?php endif ?>

<?php echo link_to(__('Return to list', null, 'sfSocial'), '@sf_social_contact_list') ?>