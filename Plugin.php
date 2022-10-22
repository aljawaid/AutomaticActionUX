<?php

namespace Kanboard\Plugin\AutomaticActionUX;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base

{
    
	public function initialize()
    
	{
        
		//template
        	$this->template->setTemplateOverride('action/index', 'automaticActionUX:action/index');

        	//css
        	$this->hook->on('template:layout:css', array('template' => 'plugins/AutomaticActionUX/Assets/css/automaticactionux.css'));
    		
	}
	
	public function onStartup()
        {
               Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
        }

	
	public function getPluginName()	
	{ 		 
		return 'AutomaticActionUX';
	}

	public function getPluginAuthor() 
	{ 	 
		return 'aljawaid';
	}

	public function getPluginVersion() 
	{ 	 
		return '1.0.0';
	}

	public function getPluginDescription() 
	{ 
		return 'This plugin changes the Automatic Action interface to make it more user friendly when viewing. This is particularly useful for visual learners and non-English speaking users.';
	}

	public function getPluginHomepage() 
	{ 	 
		return 'https://github.com/aljawaid/AutomaticActionUX';
	}
}
