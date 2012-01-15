<table style="width: 630px;" class="my_table">
	<tr>
		<td style="width:60px;">
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 1:</span>
		</td>
		<td>
			<h4 class="fix">Set up your Open311 server.<sup><a href="#">?</a></sup></h4>
		</td>
	</tr>
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 2:</span>
		</td>
		<td>
			<h4 class="fix">Enter details of your Open311 server. <sup><a href="#">?</a></sup></h4>
			<div class="row">
				<h4>API key:</h4>
				<?php print form::input('api', $form['api'], ' class="text title_2"'); ?>
			</div>
			<div class="row">
				<h4>User name:</h4>
				<?php print form::input('username', $form['username'], ' class="text title_2"'); ?>
			</div>
			<div class="row">
				<h4>Password:</h4>
				<?php print form::password('password', $form['password'], ' class="text title_2"'); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<span class="big_blue_span">Step 3:</span>
		</td>
		<td>
			<h4 class="fix">Check Balance<sup><a href="#">?</a></sup></h4>
			<div class="row">
				<h4><a href="javascript:Open311Balance()">Load Balance</a>&nbsp;<span id="balance_loading"></span></h4>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 4:</span>
		</td>
		<td>
			<h4 class="fix"><a href="#" class="tooltip" title="">Working with Open311 2-Way</a></h4>
			<p>
				If you sign up for Open311 2-Way service they will ask you for a 'Primary Callback URL'. Use the URL below as the 'Target Address' and select 'HTTP POST' from the drop down.
			</p>
			<p class="sync_key">
				<span><?php echo $link; ?></span>
			</p>
		</td>
	</tr>								
</table>
