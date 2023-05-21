<?php

namespace Kanboard\Plugin\AutomaticActionUX;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        // Template Override
        //  - Override name should be camelCase e.g. pluginNameExampleCamelCase
        $this->template->setTemplateOverride('action/index', 'automaticActionUX:action/index');

        // CSS - Asset Hook
        //  - Keep filename lowercase
        $this->hook->on('template:layout:css', array('template' => 'plugins/AutomaticActionUX/Assets/css/automatic-action-ux.css'));

        // Views - Board - Template Hook
        //  - Override name should start lowercase e.g. pluginNameExampleCamelCase
        $this->template->hook->attach('template:project:dropdown', 'automaticActionUX:project_header/actions');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getPluginName()
    {
        // Plugin Name MUST be identical to namespace for Plugin Directory to detect updated versions
        return 'AutomaticActionUX';
    }

    public function getPluginDescription()
    {
        return t('This plugin gives the Automatic Action interface a complete makeover to make it more user friendly. Particularly useful for visual learners and non-English speaking users, this plugin adds a quick glance of Actions on the board avoiding careless drag-happy mistakes.');
    }

    public function getPluginAuthor()
    {
        return 'aljawaid';
    }

    public function getPluginVersion()
    {
        return '2.6.0';
    }

    public function getCompatibleVersion()
    {
        // Examples:
        // >=1.0.37
        // <1.0.37
        // <=1.0.37
        return '>=1.2.20';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/aljawaid/AutomaticActionUX';
    }
}
