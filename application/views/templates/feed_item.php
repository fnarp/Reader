
	<li id="i<?php echo $item->feeditemid ?>" class="<?php
		echo $item->seen ? ' seen' : '';
		echo $item->favourite ? ' favourite' : '';
		echo $item->readlater ? ' readlater' : '';
	?>">
		<div class="navbar feedtitle">
			<div class="navbar-inner">
				<a class="brand" href="<?php echo $item->link ?>"><?php echo $item->title ?></a>
				<div class="pull-right">
					<ul class="nav">
						<li><a class="aj seen icon <?php echo $item->seen ? 'true' : 'false' ?>"
							href="<?php echo site_url('item/markread/'.$item->feeditemid.'/'.($item->seen ? 'true' : 'false'))?>" 
							title="Mark Read">&#10004;</a></li>
						<li><a class="aj icon <?php echo $item->favourite ? 'true' : 'false' ?>"
							href="<?php echo site_url('item/favourite/'.$item->feeditemid.'/'.($item->favourite ? 'true' : 'false'))?>"
							title="Favourite">&#9829;</a></li>
						<li><a class="aj icon <?php echo $item->readlater ? 'true' : 'false' ?>"
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
