<p>Create a folder to place feeds in.</p>
<?php echo form_open('groups/add') ?>
	<div>
		<?php echo form_label("Folder Name","name") ?>
		<?php echo form_input(array(
			'name' => 'title',
			'id' => 'title'
		)) ?>
		
	</div>
	<div>
		<?php echo form_label("Make public?","public") ?>
		<?php echo form_checkbox(array(
			'name' => 'name',
			'id' => 'name'
		)) ?>
		
	</div>
	<div>
		<?php echo form_submit('go','Make folder') ?>
	</div>
</form>
