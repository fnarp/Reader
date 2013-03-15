
		<div class="span3 sidebar">
			
			<div class="btn-group">
				<a class="btn" href="<?php echo site_url("feeds/add") ?>">Add Feed</a>
				<a class="btn" href="<?php echo site_url("groups/add") ?>">New Folder</a>
			</div>
			
			<div class="scroller">
				<ul class="nav nav-list">
					<?php
						$grouptitle = '';
						foreach($feeds->result() as $feed):
						if($grouptitle != $feed->grouptitle): ?>
						<li class="nav-header">
							<a href="<?php echo site_url("groups/view/".$feed->groupid) ?>"><?php echo $feed->grouptitle ?></a>
						</li>
						<?php endif; ?>
						<li id="f<?php echo $feed->feedid ?>">
							<a href="<?php echo site_url("feeds/view/".$feed->feedid) ?>">
								<span class="f"></span>
								<?php echo $feed->feedtitle ?>
								<?php if($feed->articles > 0 && $feed->unread > 0) echo "({$feed->unread})"?>
							</a>
						</li>
						<?php
						$grouptitle = $feed->grouptitle;
						endforeach;
						?>
				</ul>
			</div>
			
		</div>
		<div class="span6 main-content">
