<?php
class  csvGmp extends moduleGmp {
	private $_markerHeaders = array();
	private $_mapHeaders = array();
	
	public function init() {
		dispatcherGmp::addFilter('additionalGlobalSettings', array($this, 'addSettingsBlock'));
	}
	public function addSettingsBlock($bloks) {
		frameGmp::_()->addScript('admin.csv', $this->getModPath(). 'js/admin.csv.js');
		$bloks[] = $this->getView()->getSettitngsBlockHtml();
		return $bloks;
	}
	public function getMarkerHeadersList() {
		if(empty($this->_markerHeaders)) {
			$this->_markerHeaders = array(
				'id' => 'ID',
				'title' => 'Title',
				'description' => 'Description',
				'map_id' =>  'Map ID',
				'address' =>  'Address',
				'coord_x' =>  'Coord. X',
				'coord_y' =>  'Coord. Y',
				'animation' =>  'Animation',
				
				'icon' =>  'Icon ID',
				'icon_path' =>  'Icon Path',
				'icon_title' =>  'Icon Title',
				
				'marker_group_id' =>  'Group ID',
				'marker_group_title' =>  'Group Title',
				'marker_group_description' =>  'Group Description',
			);
		}
		return $this->_markerHeaders;
	}
	public function getMapHeadersList() {
		if(empty($this->_mapHeaders)) {
			$this->_mapHeaders = array(
				'id' => 'ID',
				'title' => 'Title',
				'description' => 'Description',
				// params
				'enable_zoom' => 'Enable Zoom',
				'enable_mouse_zoom' => 'Enable Mouse Zoom', 
				'zoom' => 'Zoom', 
				'type' => 'Type',
				'language' => 'Language',
				'map_display_mode' => 'Display mode',
				'map_center' => 'Map Center',
				'infowindow_height' => 'Infowindow Height',
				'infowindow_width' => 'Infowindow Width',
				// html options
				'width' => 'Width', 
				'height' => 'height', 
				'align' => 'Align', 
				'margin' => 'margin', 
				'border_color' => 'Border Color', 
				'border_width' => 'Border Width',
			);
		}
		return $this->_mapHeaders;
	}
}