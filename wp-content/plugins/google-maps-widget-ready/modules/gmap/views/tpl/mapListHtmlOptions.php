<?php
$options = array();
foreach($this->map['html_options'] as $k => $v) {
	$options[] = $k. ': '. $v;
}
echo implode(', ', $options);
?>