<h2><?php echo __('Searching &quot;%1%&quot;', array('%1%' => $name), 'sfSocial') ?></h2>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No user found', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $user): ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?>">
    <?php /* escaping strategy safety */ $_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>
    <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@sf_social_user?username=' . $_user) ?>
    <div>
      <?php echo link_to($_user, '@sf_social_user?username=' . $_user) ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<div id="pager">
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_user_search?name=' . $name . '&page=' . $page) ?>
<?php endforeach ?>
</div>
<?php endif ?>

<?php endif ?>