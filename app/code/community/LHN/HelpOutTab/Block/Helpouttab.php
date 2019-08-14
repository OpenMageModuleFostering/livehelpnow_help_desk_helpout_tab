<?php
class LHN_HelpOutTab_Block_Helpouttab extends Mage_Core_Block_Template
{
    public function getLhnOptions($param)
    {
        return str_replace("lhn", "", strtolower(Mage::getStoreConfig('lhn_helpouttab/general/'.$param)));
    }
}