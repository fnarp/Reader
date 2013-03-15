<h1><?php echo $title ?></h1>

<p>Upload an OPML file to import your feeds from another application or service.</p>

<?php if(isset($error)) echo $error ?>

<?php echo form_open_multipart('import/upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>
