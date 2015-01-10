<?php
class  gmapGmp extends moduleGmp {
	public function init() {
		if(frameGmp::isAdminPlugPage()){
			frameGmp::_()->addScript('gmp', GMP_JS_PATH. 'gmp.js', array(), false, false);
			frameGmp::_()->addScript('mutal_opts', GMP_JS_PATH. 'mutal.js', array(), false, false);	
			frameGmp::_()->addStyle('map_std', $this->getModPath(). 'css/map.css');  
		}
		dispatcherGmp::addFilter('adminOptionsTabs', array($this, 'addOptionsTab'));
		dispatcherGmp::addAction('tplHeaderBegin',array($this, 'showFavico'));
		dispatcherGmp::addAction('tplBodyEnd',array($this, 'GoogleAnalitics'));

        add_action('wp_footer', array($this, 'addMapDataToJs'));
	}
	public function addOptionsTab($tabs) {
		if(frameGmp::isAdminPlugPage()){
			frameGmp::_()->addScript('mapOptions', $this->getModPath(). 'js/admin.maps.options.js');
			frameGmp::_()->addScript('bootstrap', GMP_JS_PATH .'bootstrap.min.js');
			frameGmp::_()->addStyle('bootstrapCss', GMP_CSS_PATH .'bootstrap.min.css');			
		}
		return $tabs;
	}
    public function drawMapFromShortcode($params = null) {
		frameGmp::_()->addScript('commonGmp', GMP_JS_PATH. 'common.js', array('jquery'));
		frameGmp::_()->addScript('coreGmp', GMP_JS_PATH. 'core.js');
		frameGmp::_()->addScript('mutal_opts', GMP_JS_PATH. 'mutal.js');
        if(!isset($params['id'])) {
            return $this->getController()->getDefaultMap();
        }
        return $this->getController()->getView()->drawMap($params);
    }
    public function addMapDataToJs(){
        $this->getView()->addMapDataToJs();
    }
	public function getMapsTab() {
		return $this->getView()->getMapsTab();
	}
	public function generateShortcode($map) {
		$shortcodeParams = array();
		$shortcodeParams['id'] = $map['id'];
		// For PRO version
		$shortcodeParamsArr = array();
		foreach($shortcodeParams as $k => $v) {
			$shortcodeParamsArr[] = $k. "='". $v. "'";
		}
		return '[ready_google_map '. implode(' ', $shortcodeParamsArr). ']';
	}
	/*public function getMapImgSrc($map) {
		$query = array(
			
		);
		return 'http://maps.google.com/maps/api/staticmap?'. http_build_query($query);
		return 'http://maps.google.com/maps/api/staticmap?center=46.9750330,31.9945830&zoom=16&size=600x400&maptype=roadmap&sensor=false&language=&markers=color:red|label:none|46.9750330,31.9945830&markers=color:green|label:none|46.9750910,31.9945930';
	}*/
}