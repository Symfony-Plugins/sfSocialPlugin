<?php if (!$pager->getResults()): ?>
<h2><?php echo __('No events yet') ?></h2>
<?php else: ?>
<h2><?php echo __('Events') ?></h2>
<?php endif ?>

<!-- TODO to be finished -->

<pre>
  <?php print_r($pager->getResults()) ?>
</pre>