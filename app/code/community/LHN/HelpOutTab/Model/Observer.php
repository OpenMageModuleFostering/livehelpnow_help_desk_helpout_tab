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
			
			$whiteLabel = '';
			if(substr($lhn_account_number, -2) == "-1"){
				$whiteLabel = 'var lhnWhiteLabel = true;'.PHP_EOL;
			}
			$lhn_account_number = str_replace("-1", "", $lhn_account_number);
			
			$lhncontent = '<script type="text/javascript">'.PHP_EOL;
			$lhncontent .= 'if(lhnHPPanel===undefined){'.PHP_EOL;
			$lhncontent .= $whiteLabel;
			$lhncontent .= 'var lhnCustom1 = "'.$lhnEmail.'";'.PHP_EOL;
			$lhncontent .= 'var lhnCustom2 = "'.$lhnCustomer.'";'.PHP_EOL;
			$lhncontent .= 'var lhnCustom3 = "'.$lhnCart.'";'.PHP_EOL;
			$lhncontent .= 'var lhnVersion = 5.3;'.PHP_EOL;
			$lhncontent .= 'var lhnAccountN = '.$lhn_account_number.';'.PHP_EOL;
			$lhncontent .= 'var lhnButtonN = -1;'.PHP_EOL;
			$lhncontent .= 'var lhnJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");'.PHP_EOL;
			$lhncontent .= 'var lhnInviteEnabled = '.$lhn_autochat.';'.PHP_EOL; 
			$lhncontent .= 'var lhnInviteChime = 0; '.PHP_EOL;
			$lhncontent .= 'var lhnWindowN = '.$lhn_chat_window.'; '.PHP_EOL;
			$lhncontent .= 'var lhnDepartmentN = 0; '.PHP_EOL;
			$lhncontent .= 'var lhnCustomInvitation ="";'.PHP_EOL;
			$lhncontent .= 'var lhnTrackingEnabled = "t";'.PHP_EOL;
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
			$lhncontent .= 'if(!lhnHPKnowledgeBase && !lhnHPTicketButton && !lhnHPCallbackButton){'.PHP_EOL;
			$lhncontent .= 'lhnHPChatButton = true;'.PHP_EOL;
			$lhncontent .= 'lhnHPPanel = false;'.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= 'var loadLHNFile = function (url, type) { if (type == "js") { var file = document.createElement("script"); file.setAttribute("type", "text/javascript"); file.setAttribute("src", url); } else if (type = "css") { var file = document.createElement("link"); file.setAttribute("rel", "stylesheet"); file.setAttribute("type", "text/css"); file.setAttribute("href", url); } if (typeof file != "undefined") { document.getElementsByTagName("head")[0].appendChild(file) } }'.PHP_EOL;
			$lhncontent .= 'var loadLHNFiles = function () {'.PHP_EOL;
			$lhncontent .= 'if (lhnHPChatButton == true && typeof lhnInstalled == "undefined") {'.PHP_EOL;
			$lhncontent .= 'if (!document.getElementById("lhnChatButton")) {'.PHP_EOL;
			$lhncontent .= 'if (document.body) {'.PHP_EOL;
			$lhncontent .= 'var lhnBTNdiv = document.createElement("div");'.PHP_EOL;
			$lhncontent .= 'lhnBTNdiv.id = "lhnChatButton";'.PHP_EOL;
			$lhncontent .= 'if (document.body.lastChild) { document.body.insertBefore(lhnBTNdiv, document.body.lastChild); } else { document.body.appendChild(lhnBTNdiv); }'.PHP_EOL;
			$lhncontent .= '} else {'.PHP_EOL;
			$lhncontent .= 'document.write("<div id=\"lhnChatButton\"></div>");'.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= 'loadLHNFile(lhnJsHost + "www.livehelpnow.net/lhn/scripts/livehelpnow.aspx?lhnid=" + lhnAccountN + "&iv=" + lhnInviteEnabled + "&d=" + lhnDepartmentN + "&ver=" + lhnVersion + "&rnd=" + Math.random(), "js");'.PHP_EOL;
			$lhncontent .= 'window.setTimeout("if (typeof bLHNOnline != \'undefined\' && bLHNOnline == 0 && lhnHPPanel == true){document.getElementById(\'lhn_live_chat_btn\').style.display=\'none\';}", 2000);'.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= 'loadLHNFile(lhnJsHost + "www.livehelpnow.net/lhn/js/build/helppanel.ashx", "js");'.PHP_EOL;
			$lhncontent .= 'loadLHNFile(lhnJsHost + "www.livehelpnow.net/lhn/js/css/helppanel/" + lhnTheme + "/style.css", "css"); '.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= 'if (window.addEventListener) {'.PHP_EOL;
			$lhncontent .= 'window.addEventListener("load", function () {'.PHP_EOL;
			$lhncontent .= 'loadLHNFiles();'.PHP_EOL;
			$lhncontent .= '}, false);'.PHP_EOL;
			$lhncontent .= '} else if (window.attachEvent) {'.PHP_EOL;
			$lhncontent .= 'window.attachEvent("onload", function () {'.PHP_EOL;
			$lhncontent .= 'loadLHNFiles();'.PHP_EOL;
			$lhncontent .= '});'.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= '}'.PHP_EOL;
			$lhncontent .= '</script>"'.PHP_EOL;
			
			echo $lhncontent;
		}
	}
}