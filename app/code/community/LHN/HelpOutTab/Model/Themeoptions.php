<?php
class LHN_HelpOutTab_Model_Themeoptions{
	public function toOptionArray(){
		return array(
			array('value' => 'default', 'label' => 'default'),
			array('value' => 'red', 'label' => 'red'),
			array('value' => 'orange', 'label' => 'orange'),
			array('value' => 'yellow', 'label' => 'yellow'),
			array('value' => 'green', 'label' => 'green'),
			array('value' => 'blue', 'label' => 'blue'),
			array('value' => 'purple', 'label' => 'purple')
		);
	}
}