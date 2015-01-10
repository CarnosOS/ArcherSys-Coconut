<div class="gmpMapsContainer">
    <?php /*?><div class="refreshMapsList">
        <a class="btn btn-success" id="gmpRefreshMapsList" onclick="getMapsList()">
            <span class="gmpIcon gmpIconRefresh"></span>
            <?php langGmp::_e('Refresh');?>
        </a>
    </div><?php */?>
	<script type='text/javascript'>
		var existsMapsArr = JSON.parse('<?php  echo utilsGmp::listToJson($this->mapsArr);?>');
		var defaultOpenTab = "<?php echo $this->currentTab;?>";
		//gmpActiveTab.mainmenu = "#<?php echo str_replace("#", "", $this->currentTab); ?>";
	</script>
	<div id="gmpAllMapsListShell">
		<?php echo $this->allMaps?>
	</div>
	<div id="gmpEditMapShell" style="display: none;">
		<?php echo $this->editMap?>
	</div>
</div> 


