<?php
	if(empty($this->data['width']))
		$this->data['width'] = '100%';
?>
<p>
    <label for="<?php echo $this->widget->get_field_id('id')?>"><?php langGmp::_e('Select map')?>:</label>
    <?php 
        echo htmlGmp::selectbox($this->widget->get_field_name('id'), array(
            'attrs' => 'id="'. $this->widget->get_field_id('id'). '"',
            'value' => $this->data['id'],
            'options' => $this->mapsOpts,
        ));
    ?><br />
    <label for="<?php echo $this->widget->get_field_id('width')?>"><?php langGmp::_e('Widget Map width')?>:</label>
    <?php
        echo htmlGmp::text($this->widget->get_field_name('width'), array(
            'attrs' => 'id="'. $this->widget->get_field_id('width'). '"',
            'value' => $this->data['width'],
        ));
    ?><br />
	<label for="<?php echo $this->widget->get_field_id('height')?>"><?php langGmp::_e('Widget Map height')?>:</label>
    <?php
        echo htmlGmp::text($this->widget->get_field_name('height'), array(
            'attrs' => 'id="'. $this->widget->get_field_id('height'). '"',
            'value' => $this->data['height'],
        ));
    ?><br />
	<label for="<?php echo $this->widget->get_field_id('display_as_img')?>"><?php langGmp::_e('Display as image')?>:</label>
	
    <?php
        echo htmlGmp::checkbox($this->widget->get_field_name('display_as_img'), array(
            'attrs' => 'id="'. $this->widget->get_field_id('display_as_img'). '"',
            'checked' => isset($this->data['display_as_img']),
        ));
    ?><br />
	<i><?php langGmp::_e('Map will be displayed as image at sidebar, on click - will be opened in popup')?></i><br />
	
</p>