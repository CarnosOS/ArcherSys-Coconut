<?php
class optionsViewGmp extends viewGmp {
	public function getAdminPage() {
		if(!installerGmp::isUsed()){
			frameGmp::_()->getModule('promo_ready')->showWelcomePage();
			return;
		}
		$tabsData = array(
			'gmpAllMaps'		=> array(
				'title'   => 'All Maps', 
				'content' => frameGmp::_()->getModule('gmap')->getMapsTab()),
			'gmpMarkerList'		=> array(
				'title' => 'Markers',
				'content' => frameGmp::_()->getModule('marker')->getView()->showAllMarkers()),
			'gmpMarkerGroups'	=> array(
				'title'   => 'Marker Groups',
				'content' => $this->getMarkersGroupsTab()),
			'gmpPluginSettings'	=>array(
				'title' => 'Plugin Settings',
				'content' => $this->getPluginSettingsTab())						
		);
		$tabsData = dispatcherGmp::applyFilters('adminOptionsTabs', $tabsData);
		
		$indoWindowSize  = utilsGmp::unserialize($this->getModel('options')->get('infowindow_size'));
		$defaultOpenTab = reqGmp::getVar('tab', 'get');

		$this->assign('tabsData', $tabsData);
		$this->assign('indoWindowSize', $indoWindowSize);
		$this->assign('defaultOpenTab', $defaultOpenTab);
		parent::display('optionsAdminPage');
	}
	
	public function getPluginSettingsTab() {
		$saveStatistic = $this->getModel('options')->getStatisticStatus();
		$indoWindowSize  = utilsGmp::unserialize($this->getModel('options')->get('infowindow_size'));
		$this->assign('saveStatistic', $saveStatistic);
		$this->assign('indoWindowSize', $indoWindowSize);
		$this->assign('additionalGlobalSettings', dispatcherGmp::applyFilters('additionalGlobalSettings', array()));
		return parent::getContent('settingsTab');
	}
	public function getMarkersGroupsTab(){
		return  frameGmp::_()->getModule('marker_groups')->getModel()->showAllGroups();
	}
	public function displayDeactivatePage(){
		$this->assign('GET', reqGmp::get('get'));
		$this->assign('POST',reqGmp::get('post'));
		$this->assign('REQUEST_METHOD', strtoupper(reqGmp::getVar('REQUEST_METHOD', 'server')));
		$this->assign('REQUEST_URI', basename(reqGmp::getVar('REQUEST_URI', 'server')));
		parent::display('deactivatePage');
	}
}
