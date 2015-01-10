<?php
class adminmenuGmp extends moduleGmp {
    public function init() {
        parent::init();
        $this->getController()->getView('adminmenu')->init();
		$plugName = plugin_basename(GMP_DIR. GMP_MAIN_FILE);
		add_filter('plugin_action_links_'. $plugName, array($this, 'addSettingsLinkForPlug') );
    }
	public function addSettingsLinkForPlug($links) {
		array_unshift($links, '<a href="'. uriGmp::_(array('baseUrl' => admin_url('admin.php'), 'page' => frameGmp::_()->getModule('adminmenu')->getView()->getMainSlug())). '">'. langGmp::_('Settings'). '</a>');
		return $links;
	}
}

