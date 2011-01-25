<?php
defined('_JEXEC') or die; 

jimport('joomla.plugin.plugin');
jimport('joomla.environment.browser');

class plgSystemPlg_ie6 extends JPlugin {

	public function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
	}

	public function onAfterRoute() {
		$app =& JFactory::getApplication();
		$tmpl = JRequest::getVar('tmpl', 'cmd');
		
		
	
		if ($tmpl != 'ie6' && $app->isSite() && $this->params->get('type') === 'redirect') {
			$browser =& JBrowser::getInstance();
			if (($browser->getBrowser() == 'msie' && $browser->getMajor() == '6') ||
					($this->params->get('test') === 'yes')) {
						
				$app->redirect($this->params->get('redirect'));
			}
		}
	}
	
	public function onAfterRender() {
		$app =& JFactory::getApplication();
	
		if ($app->isSite() && $this->params->get('type') === 'bar') {
			$browser =& JBrowser::getInstance();
			if (($browser->getBrowser() == 'msie' && $browser->getMajor() == '6') ||
					($this->params->get('test') === 'yes')) {
				$body = JResponse::getBody();
				
				$pattern = "/(<body .*?>)/i";
				$replace = 	'$1<div class="ie6warn">'.
										$this->params->get('message').
										'Click <a href="'.$this->params->get('redirect').
										'">here</a> for more information.</div>';
										
				if ($this->params->get('css') === 'yes') {
					$replace .= '
<style rel="stylesheet">					
.ie6warn {
	background-color: yellow;
	border: 1px solid black;
	padding: 5px;
	margin: 0 0 5px 0;
}					
</style>';		
				}
				
				$body = preg_replace($pattern, $replace, $body, 1);
				
				JResponse::setBody($body);
			}
		}
	}
}