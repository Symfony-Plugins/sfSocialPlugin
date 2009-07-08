<h2><?php echo __('Sent messages', null, 'sfSocial') ?></h2>

<?php if (!$pager->getResults()): ?>
<p>
  <?php echo __('No sent messages yet', null, 'sfSocial') ?>
</p>
<?php else: ?>

<ul id="list">
<?php foreach ($pager->getResults() as $rcpt): ?>
<?php $message = $rcpt->getSfSocialMessage() ?>
  <li class="<?php $bRow = empty($bRow) ? print('a') : false ?> read">
    <div class="date"><?php echo $message->getCreatedAt() ?></div>
    <div class="subject">
      <?php echo link_to($message->getSubject(), '@sf_social_message_sentread?id=' . $message->getId()) ?>
    </div>
    <div class="to">
      <?php echo link_to(image_tag($rcpt->getsfGuardUser()->getThumb(), 'title=' . $rcpt->getsfGuardUser()), '@sf_social_user?username=' . $rcpt->getsfGuardUser()) ?>
    </div>
  </li>
<?php endforeach ?>
</ul>

<?php if ($pager->haveToPaginate()): ?>
<?php foreach ($pager->getLinks() as $page): ?>
<?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_message_sentlist?page=' . $page) ?>
<?php endforeach ?>
<?php endif ?>

<?php endif ?>

<?php echo link_to(__('Received messages', null, 'sfSocial'), '@sf_social_message_list') ?>