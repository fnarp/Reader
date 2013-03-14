<h1><?php echo $feed->title ?></h1>

<p><?php echo $feed->description ?></p>

<?php if(count($items->result()) == 0): ?>
<p>There are no items in this feed. Check the site to see if the author has posted anything.</p>
<?php else: ?>
<ul>
<?php foreach($items->result() as $item): ?>
	<li>
		<div class="title">
			<h2><a href="<?php echo $item->link ?>"><?php echo $item->title ?></a></h2>
		</div>
		<div class="content">
			<?php echo $item->description ?>
		</div>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
