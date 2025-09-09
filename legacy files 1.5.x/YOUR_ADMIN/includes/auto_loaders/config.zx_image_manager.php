<?php
/*
* ZX Backup to Google Drive
* Admin auto-loader for installer script
* Last updated: v1.0.0
*/

if (!defined('IS_ADMIN_FLAG') || IS_ADMIN_FLAG !== true) {
    die('Illegal Access');
}

$autoLoadConfig[999][] = [
    'autoType' => 'init_script',
    'loadFile' => 'init_zx_image_manager_installer.php'
];
