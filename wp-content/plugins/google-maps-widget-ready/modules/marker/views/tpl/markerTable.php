<script type='text/javascript'>
    var gmpExistsMarkers = JSON.parse('<?php echo utilsGmp::listToJson($this->markerList); ?>');
</script>
<table class="gmpTable" id="gmpTableMarkers">
	<thead>
	<?php foreach($this->displayColumns as $col) { ?>
		<th class="">
			<?php echo $col['label']?>
		</th>
	<?php }?>
	</thead>
	<tbody></tbody>
	<?php /*?>
      <thead>
          <tr>
              <th><?php langGmp::_e("ID");?>    </th>
              <th><?php langGmp::_e("Icon");?>  </th>
              <th><?php langGmp::_e("Title");?> </th>
              <th>
                  <?php langGmp::_e("Description");?>
              </th>

              <th class='gmpThMarkerGroups'>
                  <?php langGmp::_e("Group");?>
              </th>
              <th class='gmpThMarkerCreationDate'>
                  <?php langGmp::_e("Creation Date");?>
              </th>
              <th class='gmpMarkerTableaddress'>
                  <?php langGmp::_e("Address");?>
              </th>
              <th>
                  <?php langGmp::_e("Uses On Map");?>
              </th>
              <th class='thOperations'>
                  <div class='thOperations'>
                    <?php langGmp::_e("Operations");?>
                  </div>    
              </th>
          </tr>
      </thead>
      <tbody>
          <?php
              foreach($this->markerList as $marker){
                  ?>
          <tr id='markerRow_<?php echo $marker['id']?>'>
              <td>
                  <?php echo $marker['id']?>
              </td>
              <td>
                  <div class="gmpMarkerListIconItem">
                      <img src='<?php echo $marker['icon']['path'];?>' />
                  </div>   
              </td>
              <td>
				  <?php
					if($marker['titleLink'] && $marker['titleLink']['linkEnabled']=='true'){
						//outGmp($marker['titleLink']);
						$marker['title']="<a href='".$marker['titleLink']['link']."' target='_blank' >".
								$marker['title']."</a>";
					}
				  ?>
                  <?php echo $marker['title'];?>
              </td>
              <td>
                  <div class='gmpMarkerTabledescContainer'>
                      <?php echo $marker['description'];?>
                  </div>   
              </td>
              <td>
                  <?php echo $marker['marker_group']['title'];?>
              </td>
              <td>
                  <?php echo $marker['create_date'];?>
              </td>
              <td>
                  <?php echo $marker['address']?><br/>
                 
                  <pre>Latitude  : <?php echo $marker['coord_y'];?><br/>Longitude : <?php echo $marker['coord_x'];?><br/></pre>
              </td> 
              <td>
                  <?php 
                      if(!empty($marker['map'])){
                          echo "<a href='#' onclick='gmpEditMap(".$marker['map']['id'].")'>".$marker['map']['title']."</a>";
                      }else{
                          echo langGmp::_("No maps contain this marker");
                      }
                  ?>
              </td>
              <td class=''>
                  <a class='btn btn-warning gmpEditBtn gmpListActBtn' id='<?php echo $marker['id']?>'
                      onclick='gmpEditMarkerItem(<?php echo $marker['id']?>); return false;'>
                      <span class='gmpIcon gmpIconEdit '></span>
                      <?php echo langGmp::_("Edit")?></a>
                  <a class='btn btn-danger gmpRemoveBtn gmpListActBtn' id='<?php echo $marker['id']?>'
                     onclick="gmpRemoveMarkerItem(<?php echo $marker['id']?>)">
                    <span class='gmpIcon gmpIconRemove '></span>
                      <?php echo langGmp::_("Remove")?>
                  </a>
                  <span id="gmpMarkerListTableLoader_<?php echo $marker['id']?>"></span>
              </td>

          </tr> 

                  <?php
              }
          ?>
      </tbody><?php */?>
</table>
<script type="text/javascript">
// <!--
jQuery(document).ready(function(){
	gmpMarkersTblColumns = <?php echo utilsGmp::jsonEncode($this->displayColumns)?>;
});
// -->
</script>

    