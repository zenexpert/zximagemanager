<?php
/**
 * ZX Backup to Google Drive
 *
 * Initialization script to install ZX Google Drive Backup
 *
 * copyright Copyright 2025 ZenExpert - https://zenexpert.com
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// -----
// Only proceed if admin is logged in and plugin is not at current version.
//
if (empty($_SESSION['admin_id']) || (defined('ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY'))) {
    return;
}

if (!defined('ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY')) {
    $db->Execute(
        "INSERT INTO " . TABLE_CONFIGURATION . "
            (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function)
         VALUES
            ('Image Manager: Allow Browsing Main Images Directory', 'ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY', 'false', 'Set to true to allow browsing of the main images directory.  This is not recommended for performance reasons.', 4, 100, NOW(), 'zen_cfg_select_option(array(\'true\', \'false\'),')"
    );

    // Register admin pages if needed
    zen_register_admin_page('toolsDisplayLogs', 'BOX_TOOLS_ZX_IMAGE_MANAGER', 'FILENAME_ZX_IMAGE_MANAGER', '', 'tools', 'Y');
}
