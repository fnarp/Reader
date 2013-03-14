
		<div class="span3">
			
			<div class="btn-group">
				<a class="btn" href="<?php echo site_url("feeds/add") ?>">Add Feed</a>
			</div>
			
			<ul class="nav nav-tabs nav-stacked">
				<?php foreach($feeds->result() as $feed): ?>
					<li>
						<a href="<?php echo site_url("feeds/view/".$feed->id) ?>"><?php echo $feed->title ?></a>
					</li>
				<?php endforeach; ?>
				
			</ul>
			
		</div>
		<div class="span6">
