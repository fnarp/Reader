<h1><?php echo $feed->title ?></h1>

<p><?php echo $feed->description ?></p>

<?php if(count($items->result()) == 0): ?>
<p>There are no items in this feed. Check the site to see if the author has posted anything.</p>
<?php else: ?>
<ul class="semantic">
<?php foreach($items->result() as $item): ?>
	<li id="i<?php echo $item->feeditemid ?>">
		<div class="navbar feedtitle">
			<div class="navbar-inner">
				<a class="brand" href="<?php echo $item->link ?>"><?php echo $item->title ?></a>
				<div class="pull-right">
					<ul class="nav">
						<li><a class="aj seen icon <?echo $item->seen ? 'true' : 'false' ?>"
							href="<?php echo site_url('item/markread/'.$item->feeditemid.'/'.($item->seen ? 'true' : 'false'))?>" 
							title="Mark Read">&#10004;</a></li>
						<li><a class="aj icon <?echo $item->favourite ? 'true' : 'false' ?>"
							href="<?php echo site_url('item/favourite/'.$item->feeditemid.'/'.($item->favourite ? 'true' : 'false'))?>"
							title="Favourite">&#9829;</a></li>
						<li><a class="aj icon <?echo $item->readlater ? 'true' : 'false' ?>"
							href="<?php echo site_url('item/readlater/'.$item->feeditemid.'/'.($item->readlater ? 'true' : 'false'))?>"
							title="Read later">&#9986;</a></li>
						<li><a
							href="<?php echo $item->link ?>"
							title="<?php echo date('r',$item->pubDate) ?>"><?php echo date('Y-m-d',$item->pubDate) ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="content">
			<?php echo $item->description ?>
		</div>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
