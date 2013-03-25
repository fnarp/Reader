<h1>Move Feed</h1>
<p>Select a destinaton for <em><?php echo $feed->title ?></em>:</p>

<ul class="semantic">
<?php foreach($groups as $groupid => $grouptitle): ?>
	<li><a href="<?php echo site_url("feeds/move/$from/$groupid") ?>"><?php echo $grouptitle ?></a></li>
<?php endforeach; ?>
</ul>

