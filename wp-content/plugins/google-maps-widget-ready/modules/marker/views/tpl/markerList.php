<div class="gmpMarkerListTable markerListConOpts tab-pane active">
	<?php /*?><div class="gmpMarkerListsOPerations">
		<a class="btn btn-success" onclick="gmpRefreshMarkerList(); return false;">
			<span class="gmpIcon gmpIconRefresh"></span>
			<?php langGmp::_e('Refresh')?>
		</a>
	</div><?php */?>
	<div class="gmpMTablecon">
		<?php echo @$this->tableContent; ?>
	</div>
</div>

<div class="gmpMarkerEditForm tab-pane markerListConOpts">
	<div class="return-marker-list">
		<a class="btn btn-link gmpCancelMarkerEditing" id="gmpCancelMarkerEditing">
			<?php langGmp::_e('Back To Markers List')?>
		</a>
	</div>
	<div id="gmpMarkerSingleFormShell" style="float: left; width: 40%;"></div>
	<?php //echo $this->markerForm; ?>
	
	<div class="gmp-marker-right-block" style="width: 55%;">
		<div class="gmpMapForMarkerEdit" id="gmpMapForMarkerEdit">

		</div>
		<div style="clear:both"></div>
		<?php if(!frameGmp::_()->getModule('license')) {?>
		<div class="gmpUnderMapPic">
			<div class="gmp-pic-title">
				<h4><a target="_blank"  href="http://readyshoppingcart.com/product/google-maps-plugin/"><?php langGmp::_e('PRO version img');?></a></h4>	
			</div>
			<div class="gmp-undermap-pic">
				<a target="_blank"  href="http://readyshoppingcart.com/product/google-maps-plugin/">
					<img src='<?php echo GMP_IMG_PATH ;?>underMapPic.jpg' />
				</a>
			</div>
		</div>
		<?php }?>
	</div>
</div>
     