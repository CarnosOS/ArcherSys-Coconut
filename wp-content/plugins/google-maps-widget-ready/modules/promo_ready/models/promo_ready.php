<?php
class promo_readyModelGmp extends modelGmp {
	private $_apiUrl = '';
	public function __construct() {
		$this->_apiUrl = implode('', array('ht','tp:','/','/r','ea','dy','sh','opp','i','n','gc','ar','t','.','c','o','m/'));
	}
	public function welcomePageSaveInfo($d = array()) {
		$d['where_find_us'] = (int) $d['where_find_us'];
		$desc = '';
		if(in_array($d['where_find_us'], array(4, 5))) {
			$desc = $d['where_find_us'] == 4 ? $d['find_on_web_url'] : $d['other_way_desc'];
		}
		$reqUrl = $this->_apiUrl. '?mod=options&action=saveWelcomePageInquirer&pl=rcs';
		wp_remote_post($reqUrl, array(
			'body' => array(
				'site_url' => get_bloginfo('wpurl'),
				'site_name' => get_bloginfo('name'),
				'where_find_us' => $d['where_find_us'],
				'desc' => $desc,
				'plugin_code' => 'gmw',	// To make sure that this is not maps
			)
		));
		// In any case - give user posibility to move futher
		return true;
	}
	public function saveUsageStat($code) {
		$query = '';
		$update = dbGmp::exist('@__usage_stat', 'code', $code);
		if($update){
			$query .= 'UPDATE';
		}else{
			$query .= 'INSERT INTO';
		}
		$query .= ' @__usage_stat SET code = "'. $code.'", visits = visits + 1';
		if($update){
			$query .= ' WHERE code = "'. $code. '"';
		}	   
		return dbGmp::query($query);
	}
	public function saveSpentTime($code, $spent) {
		$spent = (int) $spent;
		$query = 'UPDATE @__usage_stat SET spent_time = spent_time + '. $spent. ' WHERE code = "'. $code. '"';
		return dbGmp::query($query);
	}
	public function getAllUsageStat() {
		$query = 'SELECT * FROM @__usage_stat';
		return dbGmp::get($query);
	}
	public function sendUsageStat() {
		$allStat = $this->getAllUsageStat();
		$reqUrl = $this->_apiUrl. '?mod=options&action=saveUsageStat&pl=rcs';
		$res = wp_remote_post($reqUrl, array(
			'body' => array(
				'site_url' => get_bloginfo('wpurl'),
				'site_name' => get_bloginfo('name'),
				'plugin_code' => 'gmw',
				'all_stat' => $allStat
			)
		));
		$this->clearUsageStat();
		// In any case - give user posibility to move futher
		return true;
	}
	public function clearUsageStat() {
		$query = 'DELETE FROM @__usage_stat';
		return dbGmp::query($query);
	}
	public function getUserStatsCount() {
		$query = 'SELECT COUNT(*) AS total FROM @__usage_stat';
		return (int) dbGmp::get($query, 'one');
	}
	public function checkAndSend(){
		$res = frameGmp::_()->getTable("usage_stat")->get("id",'`visits`>9');
		if(!empty($res)){
			$this->sendUsageStat();
		}
	}
}
