<h1><?php echo html_escape($usergroup->title) ?></h1>

<?php if(count($items->result()) == 0): ?>
<p>There are no feeds here yet. Why not <a href="<?php echo site_url("feeds/add") ?>">add one</a>?</p>
<?php else: ?>
<ul class="semantic">
<?php foreach($items->result() as $item): ?>
	<?php $this->load->view('templates/feed_item',array('item' => $item)); ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
