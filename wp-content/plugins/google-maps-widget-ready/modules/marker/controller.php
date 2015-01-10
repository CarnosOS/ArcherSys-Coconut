<?php
class markerControllerGmp extends controllerGmp {
	public function saveMarkers($markerArr = array(), $mapId = false) {
        $res = new responseGmp();
        if(empty($markerArr) || !$mapId) {
            $res->pushError(langGmp::_('Empty data'));
        } else {
            if($this->getModel()->saveMarkers($markerArr, $mapId)){
                return true;
            } else {
                $res->pushError($this->getModel()->getErrors());
            }
        }
        frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("marker.save");        
        return $res->ajaxExec();
    }
	public function save() {
		$res = new responseGmp();
		$markerData = reqGmp::getVar('marker_opts');
		$update = false;
		if($id = $this->getModel()->save($markerData, $update)){
			$res->addMessage(langGmp::_('Done'));
			$res->addData('marker', $this->getModel()->getById($id));
			$res->addData('update', $update);
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
        frameGmp::_()->getModule('promo_ready')->getModel()->saveUsageStat('marker.save');
        return $res->ajaxExec();
	}
    public function getMapMarkers($mapId = false){
        if(!$mapId) {
            return false;
        }
        return $this->getModel()->getMapMarkers($mapId);
    }
    public function findAddress(){
        $data = reqGmp::get('post');
        $res = new responseGmp();
        $result = $this->getModel()->findAddress($data);
        if($result) {
            $res->addData($result);
        } else {
			$res->pushError($this->getModel()->getErrors());
        }
        frameGmp::_()->getModule('promo_ready')->getModel()->saveUsageStat('geolocation.address.search');        
        return $res->ajaxExec();
    }
    public function removeMarker(){
        $params = reqGmp::get('post');
        $res =new responseGmp();
        if(!isset($params['id'])){
            $res->pushError(langGmp::_("Marker Not Found"));
            return $res->ajaxExec();
        }    
        if($this->getModel()->removeMarker($params["id"])){
           $res->addMessage(langGmp::_("Done")); 
        }else{
            $res->pushError(langGmp::_("Cannot remove marker"));
        }
        frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("marker.delete");        
        return $res->ajaxExec();
    }
    public function refreshMarkerList(){
        $markers = $this->getModel()->getAllMarkers();
        $data = $this->getView()->showMarkersTab($markers,true);
        $res= new responseGmp();
        $res->setHtml($data);
        return $res->ajaxExec();
    }
    public function updateMarker(){
        $data = reqGmp::get("post");
        $res = new responseGmp();
        if(!isset($data['markerParams']) || !isset($data['markerParams']['id'])){
            $res->pushError(langGmp::_("Empty Marker"));
            return $res->ajaxExec();
        }
        if($this->getModel()->updateMarker($data['markerParams'])){
            $res->addMessage(langGmp::_("Done"));
        }else{
            $res->pushError(langGmp::_("Database Error."));
        }
        frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("marker.edit");        
        return $res->ajaxExec();
    }
	public function getMarkerForm($params){
		return $this->getView()->getMarkerForm($params);
	}
	public function getListForTable() {
		$res = new responseGmp();
		$res->ignoreShellData();
		
		$count = $this->getModel()->getCount();
		$listReqData = array(
			'limitFrom' => reqGmp::getVar('iDisplayStart'),
			'limitTo' => reqGmp::getVar('iDisplayLength'),
		);
		$displayColumns = $this->getView()->getDisplayColumns();
		$displayColumnsKeys = array_keys($displayColumns);
		$iSortCol = reqGmp::getVar('iSortCol_0');
		if(!is_null($iSortCol) && is_numeric($iSortCol)) {
			$listReqData['orderBy'] = $displayColumns[ $displayColumnsKeys[ $iSortCol ] ]['db'];
			$iSortDir = reqGmp::getVar('sSortDir_0');
			if(!is_null($iSortDir)) {
				$listReqData['orderBy'] .= ' '. strtoupper($iSortDir);
			}
		}
		$search = reqGmp::getVar('sSearch');
		if(!is_null($search) && !empty($search)) {
			$dbSearch = dbGmp::escape($search);
			$listReqData['additionalCondition'] = 'title LIKE "%'. $dbSearch. '%" OR description LIKE "%'. $dbSearch. '%"';
		}
		$list = $this->getModel()->getAllMarkers( $listReqData, true );

		$res->addData('aaData', $this->_convertDataForDatatable($list));
		$res->addData('iTotalRecords', $count);
		$res->addData('iTotalDisplayRecords', $count);
		$res->addData('sEcho', reqGmp::getVar('sEcho'));
		$res->addMessage(__('Done'));
		return $res->ajaxExec();
	}
	private function _convertDataForDatatable($list) {
		foreach($list as $i => $marker) {
			$list[$i]['list_icon'] = $this->getView()->getListIcon($list[$i]);
			$list[$i]['list_title'] = $this->getView()->getListTitle($list[$i]);
			$list[$i]['group_title'] = $list[$i]['marker_group']['title'];
			$list[$i]['list_address'] = $this->getView()->getListAddress($list[$i]);
			$list[$i]['uses_on_map'] = $this->getView()->getListUsesOnMap($list[$i]);
			$list[$i]['operations'] = $this->getView()->getListOperations($list[$i]);
		}
		return $list;
	}
	public function getMarker() {
		$res = new responseGmp();
		$id = (int) reqGmp::getVar('id');
		if($id) {
			$marker = $this->getModel()->getById($id);
			if(!empty($marker)) {
				$res->addData('marker', $marker);
			} else
				$res->pushError ($this->getModel()->getErrors());
		} else
			$res->pushError (langGmp::_('Empty or invalid marker ID'));
		return $res->ajaxExec();
	}
	public function saveFindAddressStat() {
		frameGmp::_()->getModule('promo_ready')->getModel()->saveUsageStat('geolocation.address.search');        
	}
}