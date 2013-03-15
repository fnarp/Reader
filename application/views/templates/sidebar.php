
		<div class="span3 sidebar">
			
			<div class="btn-group">
				<a class="btn" href="<?php echo site_url("feeds/add") ?>">Add Feed</a>
				<a class="btn" href="<?php echo site_url("groups/add") ?>">New Folder</a>
			</div>
			
			<ul class="nav nav-list">
				<?php
					$grouptitle = '';
					foreach($feeds->result() as $feed):
					if($grouptitle != $feed->grouptitle): ?>
					<li class="nav-header">
						<a href="<?php echo site_url("groups/view/".$feed->groupid) ?>"><?php echo $feed->grouptitle ?></a>
					</li>
					<?php endif; ?>
					<li>
						<a href="<?php echo site_url("feeds/view/".$feed->feedid) ?>"><?php echo $feed->feedtitle ?></a>
					</li>
					<?php
					$grouptitle = $feed->grouptitle;
					endforeach;
					?>
			</ul>
			
		</div>
		<div class="span6 main-content">
