<?php
class LHN_HelpOutTab_Model_Torfoptions{
	public function toOptionArray(){
		return array(
			array('value' => 'true', 'label' => 'yes'),
			array('value' => 'false', 'label' => 'no')
		);
	}
}