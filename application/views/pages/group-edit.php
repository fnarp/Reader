<div class="row feed-bar">
	<div class="span12 feed-title">
		<h1 class="title"><?php echo html_escape($usergroup->title) ?></h1>
	</div>
</div>

<?php echo form_open('groups/edit/'.$usergroup->id) ?>
	<fieldset>
		<legend>Update this folder</legend>

		<div>
			<?php echo form_label("Name","name") ?>
			<?php echo form_input(array(
				'name' => 'title',
				'id' => 'title',
				'value' => $usergroup->title
			)) ?>
			
		</div>
		<div>
			<label for="public">
			<?php echo form_checkbox(array(
				'name' => 'public',
				'id' => 'public',
				'checked' => $usergroup->public,
				'value' => '1'
			)) ?>
			Make public?
			</label>
		</div>
		<div>
			<a href="<?php echo site_url('/groups/delete/'.$usergroup->id) ?>">Delete Folder</a> and all feeds inside.
		</div>
		<div>
			<?php echo form_submit(array(
				'id' => 'go',
				'value' => 'Update folder',
				'class' => 'btn'
			)) ?>
		</div>
		
	</fieldset>
</form>
