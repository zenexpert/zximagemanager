<?php
// adapted zen_build_subdirectories_array() function to include subdirectories

function zx_build_subdirectories_array($parent_folder = '', $default_text = 'Main Directory', $level = 0, $parent_dir = '')
{
    if (empty($parent_folder)) {
        $parent_folder = DIR_FS_CATALOG_IMAGES;
    }

    // Get directories in the current folder
    $dir = glob($parent_folder . '*', GLOB_ONLYDIR);

    if (empty($dir)) {
        return [];
    }

    // Start building the directory list
    $dir_info = [];

    // Add the default text (only at the top level)
    if ($level == 0) {
        $dir_info[] = ['id' => '', 'text' => $default_text];
    }

    // Loop through each directory
    foreach ($dir as $file) {
        $basename = basename($file); // Get the base name of the directory

        // Create the indentation for subdirectories
        $indentation = str_repeat('&nbsp;&nbsp;|_', $level);

        // Build the full path for the current directory
        $full_dir = $parent_dir . $basename . '/';

        // Add the directory to the list
        $dir_info[] = ['id' => $full_dir, 'text' => $indentation . $basename];

        // Recursively add subdirectories with an increased level and full path
        $subdirs = zx_build_subdirectories_array($file . '/', $default_text, $level + 1, $full_dir);
        if (!empty($subdirs)) {
            $dir_info = array_merge($dir_info, $subdirs);
        }
    }

    return $dir_info;
}
