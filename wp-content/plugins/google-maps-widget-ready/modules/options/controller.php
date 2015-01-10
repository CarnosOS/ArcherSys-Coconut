<?php
class optionsControllerGmp extends controllerGmp {

	public function activatePlugin() {
		$res = new responseGmp();
		if ($this->getModel('modules')->activatePlugin(reqGmp::get('post'))) {
			$res->addMessage(langGmp::_('Plugin was activated'));
		} else {
			$res->pushError($this->getModel('modules')->getErrors());
		}
		return $res->ajaxExec();
	}

	public function activateUpdate() {
		$res = new responseGmp();
		if ($this->getModel('modules')->activateUpdate(reqGmp::get('post'))) {
			$res->addMessage(langGmp::_('Very good! Now plugin will be updated.'));
		} else {
			$res->pushError($this->getModel('modules')->getErrors());
		}
		return $res->ajaxExec();
	}

	public function getPermissions() {
		return array(
			GMP_USERLEVELS => array(
				GMP_ADMIN => array('save', 'saveGroup', 'saveBgImg', 'saveLogoImg', 'saveFavico',
					'saveMainGroup', 'saveSubscriptionGroup', 'setTplDefault',
					'removeBgImg', 'removeLogoImg',
					'activatePlugin', 'activateUpdate')
			),
		);
	}

	public function updatePluginSettings() {
		$data = reqGmp::get('post');
		$resp = new responseGmp();
		if (empty($data)) {
			$resp->pushError(langGmp::_('Cannot Save Info'));
			return $resp->ajaxExec();
		}
		$saveStatistic = $this->getModel('options')->updateStatisticStatus($data);
		$saveinfoWindowSize = $this->getModel('options')->updateInfoWindowSize($data['infoWindowSize']);
	}

	public function exportData() {
		$data = reqGmp::get('post');
		$exportItem = $data['to_export'];
		$res = new responseGmp();
		//$exportModule = frameGmp::_()->getModule($exportItem);

		switch ($data["gmpActionMode"]) {
			case "export":
				$maps = $data['map'];
				$mapsArr = array();
				$mapsModule = frameGmp::_()->getModule("gmap");
				foreach ($maps as $k => $map_id) {
					$mapsArr[] = $mapsModule->getModel()->getMapById($map_id, $withMarkers = true, $withGroups = true);
				}
				$uplDir = wp_upload_dir();
				$filePath = $uplDir['basedir'];

				$filename = "export" . date("Y_M_D") . "_" . rand(10, 100) . ".csv";
				$dest = $filePath . DS . $filename;
				$handle = fopen($dest, "a+");
				if ($handle) {
					file_put_contents($dest, utilsGmp::serialize($mapsArr));
				}
				fclose($handle);
				$data = array("file" => $uplDir['baseurl'] . DS . $filename);
				break;
		}

		$res->addData($data);

		return $res->ajaxExec();
	}

	public function importData() {
		
		$res = new responseGmp();
		if (!isset($_FILES['BackupFileCsv'])) {
			$res->addError(langGmp::_("Cannot Upload File"));
			return $res->ajaxExec();
		}
		$fileData =$_FILES['BackupFileCsv'];
		$uplDir = wp_upload_dir();
		$filePath = $uplDir['path'];
		$source = $fileData['tmp_name'];
		$dest = $filePath.DS.$fileData['name'];
		if(!copy($source, $dest)){
			$res->addError(langRpw::_("Cannot Copy File"));
			return $res->ajaxExec();
		}
			
		$backupInfoCsv = file_get_contents($dest);
		$backupInfo = utilsGmp::unserialize($backupInfoCsv);
		
		
		if(empty($backupInfo)){
			$res->addError(langRpw::_("Wrong Format"));
			return $res->ajaxExec();
		}

		$mapsKeys=array();
		$mapModel= frameGmp::_()->getModule("gmap")->getModel();
		$groupModule = frameGmp::_()->getModule("marker_groups");
		$markerModule = FrameGmp::_()->getModule("marker");
		$group_params = array();
		$groupKeys=array();
		$markersArr = array();
		foreach($backupInfo as $map){
			
			$map_params = array(
				"title"			=>	$map["title"],
				"description"	=>	$map["description"],
				"params"		=>	utilsGmp::serialize($map["params"]),
				"html_options"	=>	utilsGmp::serialize($map["html_options"]),
				"create_date"	=>	$map["create_date"]
			);
			//outeGmp($map_params);
			$map_new_id = frameGmp::_()->getTable("maps")->store($map_params);
			$mapsKeys[$map['id']] = $map_new_id;
			foreach($map['markers'] as $marker){
				if(isset($marker['groupObj']) && !empty($marker['groupObj'])){
					$group_params[$marker['groupObj']['id']] = 	$marker['groupObj'];	
				}
				$markersArr[] = $marker;
			}
		}
		
		foreach($group_params as $oldId=>$groupInfo){
			$gParams=array(
				"title"			=>	$groupInfo['title'],
				"description"	=>	$groupInfo['description'],
				"mode"			=>	"insert"
			);
			$groupKeys[$oldId] = $groupModule->getModel()->saveGroup($gParams);
		}
		
		foreach($markersArr as $marker){
			
			$mParams = array(
				"title" => $marker['title'],
				"description" => $marker['description'],
				"coord_x" => $marker['coord_x'],
				"coord_y" => $marker['coord_y'],
				"map_id" => $mapsKeys[$marker['map_id']],
				"marker_group_id" => $groupKeys[$marker['marker_group_id']],
				"address" => $marker['address'],
				"animation" => (int)$marker['animation'],
				"create_date" => $marker['create_date'],
				"params" => $marker['params'],
				"titleLink" => utilsGmp::serialize($marker['titleLink'])
			);
			if(is_array($marker['icon'])){
				$mParams['icon'] = $marker['icon']['id'];
			}elseif(is_string($marker['icon'])){
				$mParams['icon'] = $marker['icon'];
			}
		
			$markerModule->getModel()->saveMarker($mParams);
		}
		outGmp($mapsKeys);
		outeGmp($groupKeys);
	}

}