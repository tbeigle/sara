<div id="thumbs-<?php print $category; ?>" class="thumbs-row">
	<?php if ($horizontal) { ?>
		<div class="horizontal">
			<?php print $horizontal; ?>
		</div>
		<!-- /.horizontal -->
	<?php } ?>
	
	<?php if ($vertical) { ?>
		<div class="vertical">
			<?php print $vertical; ?>
		</div>
		<!-- /.vertical -->
	<?php } ?>
</div>
<!-- /#thumbs-<?php print $category; ?> -->