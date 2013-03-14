<p>Paste the address of the blog or feed URL.</p>
<?php echo form_open('feeds/add') ?>
	<div>
		<?php echo form_label("Address","uri") ?>
		<?php echo form_input(array(
			'name' => 'uri',
			'id' => 'uri'
		)) ?>
		
	</div>
	<div>
		<?php echo form_label("Group","group") ?>
		<?php echo form_dropdown('group',$groups,'','group') ?>
		
	</div>
	<div>
		<?php echo form_submit('go','Add') ?>
	</div>
</form>
