<h1><?php echo $usergroup->title ?></h1>

<?php if(count($items->result()) == 0): ?>
<p>There are no feeds here yet. Why not add one?</p>
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
