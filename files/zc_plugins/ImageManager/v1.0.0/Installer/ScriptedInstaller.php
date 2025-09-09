<?php

use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;

class ScriptedInstaller extends ScriptedInstallBase
{
    protected function executeInstall()
    {
        zen_deregister_admin_pages(['toolsZxImageManager']);
        zen_register_admin_page('toolsZxImageManager', 'BOX_TOOLS_ZX_IMAGE_MANAGER', 'FILENAME_ZX_IMAGE_MANAGER', '', 'tools', 'Y', 20);

        $this->addConfigurationKey('ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY', [
            'configuration_title' => 'Image Manager: Allow Browsing Main Images Directory',
            'configuration_value' => 'false',
            'configuration_description' => 'Set to true to allow browsing of the main images directory.  This is not recommended for security reasons.',
            'configuration_group_id' => 4,
            'sort_order' => 100,
            'set_function' => 'zen_cfg_select_option(array(\'true\', \'false\'), ',
        ]);
    }

    protected function executeUninstall()
    {
        zen_deregister_admin_pages(['toolsDisplayLogs']);

        $this->deleteConfigurationKeys(['ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY']);
    }
}
