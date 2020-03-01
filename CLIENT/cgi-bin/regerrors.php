<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
		<script>
			var error = <?php echo json_encode($error) ?>;
		</script>
		<script src = '../src/error.js'></script>
		<script>RegErrorHandler(error);</script>
  	<?php endforeach ?>
  </div>
<?php  endif ?>