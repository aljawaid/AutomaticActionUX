<?php

namespace Kanboard\Plugin\AutomaticActionUX;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

/**
 * Register AutomaticActionUX templates, assets and isolated translations.
 *
 * Related tests: tests/TranslationIsolationTest.php and tests/CompatibilityContractTest.php.
 */
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
        // US English is the isolated fallback before the selected catalogue overlays it.
        Translator::load('en_US', __DIR__ . '/Locale');

        $currentLanguage = $this->languageModel->getCurrentLanguage();
        if ($currentLanguage !== 'en_US') {
            Translator::load($currentLanguage, __DIR__ . '/Locale');
        }
    }

    public function getPluginName()
    {
        // Plugin Name MUST be identical to namespace for Plugin Directory to detect updated versions
        return 'AutomaticActionUX';
    }

    public function getPluginDescription()
    {
        return t('automatic_action_ux.description');
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
        return '>=1.2.54';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/aljawaid/AutomaticActionUX';
    }
}
