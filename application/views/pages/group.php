<div class="row feed-bar">
	<div class="span8 feed-title">
		<h1 class="title"><?php echo html_escape($usergroup->title) ?></h1>
	</div>
	<div class="span4 text-right feed-meta">
		<div class="btn-group">
			<a class="btn" href="<?php echo site_url("groups/edit/{$usergroup->id}") ?>" title="Folder Settings">&#9881;</a>
			
		</div>
	</div>
</div>

<?php if(count($items->result()) == 0): ?>
<p>There are no feeds here yet. Why not <a href="<?php echo site_url("feeds/add") ?>">add one</a>?</p>
<?php else: ?>
<ul class="semantic">
<?php foreach($items->result() as $item): ?>
	<?php $this->load->view('templates/feed_item',array('item' => $item)); ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
