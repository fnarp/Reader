<div class="row feed-bar">
	<div class="span8 feed-title">
		<h1 class="left">
			<?php if($feed->touchicon): ?><img class="feed-icon" src="<?php echo site_url().$feed->touchicon; ?>"> <?php endif; ?>
			<?php echo $feed->title ?>
		</h1>
	</div>
	<div class="span4 text-right feed-meta">
		<div class="btn-group">
			<a class="btn lv" href="<?php echo site_url("feeds/update/$feedid") ?>" title="Refresh Feed">&#10227;</a>
			<a class="btn lv" href="<?php echo site_url("feeds/markread/$feedid") ?>" title="Mark All Read">Mark All Read</a>
		</div>
	</div>
</div>

<p class="lead"><?php echo $feed->description ?></p>

<?php if(count($items->result()) == 0): ?>
<p>There are no items in this feed. Refresh the feed or check the site to see if the author has posted anything.</p>
<?php else: ?>
<ul class="semantic">
<?php foreach($items->result() as $item): ?>
	<?php $this->load->view('templates/feed_item',array('item' => $item)); ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
