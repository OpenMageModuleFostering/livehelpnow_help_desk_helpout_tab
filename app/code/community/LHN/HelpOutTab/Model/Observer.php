<?php
class LHN_HelpOutTab_Model_Observer{
	public function controllerFrontSendResponseAfter(Varien_Event_Observer $observer){
		if(!Mage::app()->getStore()->isAdmin()){
			$lhnEmail = "";
			$lhnCustomer = "";
			$lhnCart = "";
			if(Mage::getSingleton('customer/session')->isLoggedIn()){
				$customer = Mage::getSingleton('customer/session');
				$customerData = Mage::getModel('customer/customer')->load($customer->getId())->getData();
				
				$lhnEmail = urlencode($customerData['email']);
				$lhnCustomer = urlencode($customerData['firstname']." ".$customerData['lastname']);
				
				$cart = Mage::helper('checkout')->getQuote()->getData();
				$lhnCart = urlencode("Quantity: ".$cart['all_items_qty']." total items<br />");
				$lhnCart .= urlencode("Subtotal: ".$cart['subtotal']);
			}
		
			$lhn_account_number = Mage::getStoreConfig('lhn_helpouttab/general/account_number');
			$lhn_account_number = str_replace("lhn", "", strtolower($lhn_account_number));
			$lhn_chat_window = Mage::getStoreConfig('lhn_helpouttab/general/chat_window');
			$lhn_department = Mage::getStoreConfig('lhn_helpouttab/general/department');
			$lhn_autochat = Mage::getStoreConfig('lhn_helpouttab/general/autochat');
			$lhn_theme = Mage::getStoreConfig('lhn_helpouttab/general/theme');
			$lhn_slideout = Mage::getStoreConfig('lhn_helpouttab/general/slideout');
			$lhn_chat = Mage::getStoreConfig('lhn_helpouttab/general/chat');
			$lhn_ticket = Mage::getStoreConfig('lhn_helpouttab/general/ticket');
			$lhn_callback = Mage::getStoreConfig('lhn_helpouttab/general/callback');
			$lhn_knowbase = Mage::getStoreConfig('lhn_helpouttab/general/knowbase');
			$lhn_moreoptions = Mage::getStoreConfig('lhn_helpouttab/general/moreoptions');
			$lhn_search_title = Mage::getStoreConfig('lhn_helpouttab/general/search_title');
			$lhn_search_message = Mage::getStoreConfig('lhn_helpouttab/general/search_message');
			$lhn_no_results = Mage::getStoreConfig('lhn_helpouttab/general/no_results');
			$lhn_views = Mage::getStoreConfig('lhn_helpouttab/general/views');
			
			$lhncontent = '<script type="text/javascript">'.PHP_EOL;
			$lhncontent .= 'var lhnCustom1 = "'.$lhnEmail.'";'.PHP_EOL;
			$lhncontent .= 'var lhnCustom2 = "'.$lhnCustomer.'";'.PHP_EOL;
			$lhncontent .= 'var lhnCustom3 = "'.$lhnCart.'";'.PHP_EOL;
			$lhncontent .= 'var lhnPlugin = "Mage-'.Mage::getVersion().'-HO";'.PHP_EOL;
			$lhncontent .= 'var lhnAccountN = "'.$lhn_account_number.'";'.PHP_EOL;
			$lhncontent .= 'var lhnInviteEnabled = '.$lhn_autochat.';'.PHP_EOL; 
			$lhncontent .= 'var lhnWindowN = '.$lhn_chat_window.'; '.PHP_EOL;
			$lhncontent .= 'var lhnDepartmentN = '.$lhn_department.'; '.PHP_EOL;
			$lhncontent .= 'var lhnTheme = "'.$lhn_theme.'"; '.PHP_EOL;
			$lhncontent .= 'var lhnHPPanel = '.$lhn_slideout.'; '.PHP_EOL;
			$lhncontent .= 'var lhnHPKnowledgeBase = '.$lhn_knowbase.'; '.PHP_EOL;
			$lhncontent .= 'var lhnHPMoreOptions = '.$lhn_moreoptions.'; '.PHP_EOL;
			$lhncontent .= 'var lhnHPChatButton = '.$lhn_chat.'; '.PHP_EOL;
			$lhncontent .= 'var lhnHPTicketButton = '.$lhn_ticket.'; '.PHP_EOL;
			$lhncontent .= 'var lhnHPCallbackButton = '.$lhn_callback.'; '.PHP_EOL;
			$lhncontent .= 'var lhnLO_helpPanel_knowledgeBase_find_answers = "'.$lhn_search_title.'";'.PHP_EOL;
			$lhncontent .= 'var lhnLO_helpPanel_knowledgeBase_please_search = "'.$lhn_search_message.'";'.PHP_EOL;
			$lhncontent .= 'var lhnLO_helpPanel_typeahead_noResults_message = "'.$lhn_no_results.'";'.PHP_EOL;
			$lhncontent .= 'var lhnLO_helpPanel_typeahead_result_views = "'.$lhn_views.'";'.PHP_EOL;
			$lhncontent .= '</script>'.PHP_EOL;
			$lhncontent .= '<script src="//commondatastorage.googleapis.com/lhn/helpout/scripts/lhnhelpouttab-current.min.js" type="text/javascript" id="lhnscriptho"></script>'.PHP_EOL;
			
			echo $lhncontent;
		}
	}
}