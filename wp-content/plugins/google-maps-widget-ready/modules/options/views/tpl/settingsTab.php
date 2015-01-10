<div class="clearfix"></div>
<div class="gmpPluginSettingsFormContainer">
	<h2><?php langGmp::_e('Plugin Settings');?></h2>
	<form id="gmpPluginSettingsForm">
		<?php /*?><div class="gmpFormRow">
			<?php echo htmlGmp::checkboxHiddenVal('send_statistic', array(
				'attrs' => 'class="statistic"',
				'checked' => (bool)$this->saveStatistic))	
			?>
			<label for="gmpNewMap_title" class="gmpFormLabel">
				<?php langGmp::_e('Send anonym statistic?')?>
			</label>
		</div>
		<hr /><?php */?>
		<div class="gmp-control-group">
			<label><?php langGmp::_e('Marker Description window size')?></label>
			<div class="controls">
				<div class="gmpInfoWindowSize gmpInfoWindowSize-width">
					<label for="gmpInfoWindowSize_width"><?php langGmp::_e('Width');?></label>
					<div class="gmpSizePoint">Px</div>
					<input type="text" name="infoWindowSize[width]" class="input-mini" id="gmpInfoWindowSize_width" required="required" value="<?php echo $this->indoWindowSize['width'];?>">
				</div>
				<div class="gmpInfoWindowSize gmpInfoWindowSize-height">
					<label for="gmpInfoWindowSize_height"><?php langGmp::_e('Height');?></label>
					<div class="gmpSizePoint">Px</div>
					<input type="text" name="infoWindowSize[height]" class="input-mini" id="gmpInfoWindowSize_height" required="required" value="<?php echo $this->indoWindowSize['height'];?>">
				</div>
			</div>
		</div>
		<hr />
		<div class="controls">
			<?php
				echo htmlGmp::hidden('mod', array('value' => 'options'));
				echo htmlGmp::hidden('action', array('value' => 'updatePluginSettings'));
				echo htmlGmp::hidden('reqType', array('value' => 'ajax'));
			?>
			<div id="gmpPluginOptsMsg"></div>
			<input type="submit" class="btn btn-success" value="<?php langGmp::_e('Save')?>" />
		</div>
	</form>
</div>
<?php if(!empty($this->additionalGlobalSettings)) {
	foreach($this->additionalGlobalSettings as $setData) { ?>
		<div class="gmpPluginSettingsFormContainer"><?php echo $setData?></div>
	<?php }
}?>
<?php /*?>
<div class="importExportFormContainer">
	
</div>
<?php */?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.gmpInfoWindowSize input').keyup(function(e){
		if(e.keyCode == 0) {
			return;
		}
		var val = jQuery(this).val();
		if(val == ''){
			return false;
		}
		var res= parseInt(val);
		if(isNaN(res)) {
			res = 100;
		}
		jQuery(this).val(res);
	});
	jQuery('#gmpPluginSettingsForm').submit(function(){
		jQuery(this).sendFormGmp({
			msgElID: 'gmpPluginOptsMsg'
		,	onSuccess: function(res){
				return false;
			}
		});
		return false;
	});
});
</script>		