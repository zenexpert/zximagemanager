<?php
/**
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * copyright ZenExpert 2025
 */
require 'includes/application_top.php';

if(!defined('ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY')) define('ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY', 'false');

$currentPage = (isset($_GET['page']) && $_GET['page'] != '' ? (int)$_GET['page'] : 0);
$languages = zen_get_languages();
$extensions = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'flv', 'webm', 'ogg'];

$action = (isset($_GET['action']) ? $_GET['action'] : '');
if (!empty($action)) {
    switch ($action) {
        case 'insert':
            $path = '';
            if(!empty($_POST['img_dir'])) {
                $path =  $_POST['img_dir'];
            }
            $upload_pic = new upload('upload_pic');
            $upload_pic->set_extensions($extensions);
            $upload_pic->set_destination(DIR_FS_CATALOG_IMAGES . $path);
            if ($upload_pic->parse() && $upload_pic->save()) {
                if ($upload_pic->filename !== 'none') {
                    $messageStack->add_session(sprintf(TEXT_IMAGE_UPLOADED, $upload_pic->filename), 'success');
                } else {
                    // remove image from database if 'none'
                    $messageStack->add_session(TEXT_UPLOAD_FAILED, 'error');
                }
            }
            break;
        case 'show_pics':
            $dir = '';
            $path = DIR_FS_CATALOG_IMAGES;
            if(!empty($_POST['img_dir'])) {
                $dir = $_POST['img_dir'];
                $path .= $dir;
            }
            $fileList = [];

            // Prevent browsing the main images directory if not allowed
            if (ZXIH_ALLOW_BROWSING_MAIN_IMAGES_DIRECTORY === 'false' && $_POST['img_dir'] == '') {
                $message = '<div class="bg-danger"><p>' . TEXT_MAIN_DIR_FORBIDDEN . '</p></div>';
                break;
            }

            // Check if the directory exists
            if (is_dir($path)) {
                // Open the directory
                if ($handle = opendir($path)) {
                    // Loop through the directory files
                    while (false !== ($file = readdir($handle))) {
                        // Skip '.' and '..'
                        if ($file != "." && $file != "..") {
                            // Get the file extension
                            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                            // Check if the extension is in the allowed list
                            if (in_array($fileExtension, $extensions)) {
                                // Add the valid file to the list
                                $fileList[] = $file;
                            }
                        }
                    }
                    // Close the directory handle
                    closedir($handle);
                }
            } else {
                echo TEXT_DIRECTORY_NOT_EXISTS;
            }
            break;
        case 'new_dir':
            $path = DIR_FS_CATALOG_IMAGES;
            $new_dir = zen_db_prepare_input($_POST['new_dir']);
            if (!empty($new_dir)) {
                $full_path = $path . $new_dir;
                if (!is_dir($full_path)) {
                    if (mkdir($full_path, 0755, true)) {
                        $messageStack->add_session(TEXT_DIRECTORY_CREATED . $new_dir, 'success');
                    } else {
                        $messageStack->add_session(TEXT_DIRECTORY_NOT_CREATED . $new_dir, 'error');
                    }
                } else {
                    $messageStack->add_session(TEXT_DIRECTORY_EXISTS . $new_dir, 'error');
                }
            } else {
                $messageStack->add_session(TEXT_DIRECTORY_NAME_EMPTY, 'error');
            }
            zen_redirect(zen_href_link(FILENAME_ZX_IMAGE_MANAGER));
            break;
    }
}
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
<head>
    <?php require DIR_WS_INCLUDES . 'admin_html_head.php'; ?>

    <style>
        .flexbox {
            display: flex;
            flex-wrap: wrap;
        }

        .flexbox .galleryPic {
            margin-bottom: 10px;
        }

        .galleryPic {
            position: relative;
        }

        .delete_pic {
            position: absolute;
            top: 0;
            right: 0;
            width: 20%;
            height: 20%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
            color: red;
            font-size: 3rem;
        }

        .galleryPic:hover .delete_pic {
            opacity: 1;
        }

        .tooltipped{position:relative}.tooltipped:after{position:absolute;z-index:1000000;display:none;padding:5px 8px;font:normal normal 11px/1.5 Helvetica,arial,nimbussansl,liberationsans,freesans,clean,sans-serif,"Segoe UI Emoji","Segoe UI Symbol";color:#fff;text-align:center;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-wrap:break-word;white-space:pre;pointer-events:none;content:attr(aria-label);background:rgba(0,0,0,.8);border-radius:3px;-webkit-font-smoothing:subpixel-antialiased}.tooltipped:before{position:absolute;z-index:1000001;display:none;width:0;height:0;color:rgba(0,0,0,.8);pointer-events:none;content:"";border:5px solid transparent}.tooltipped:hover:before,.tooltipped:hover:after,.tooltipped:active:before,.tooltipped:active:after,.tooltipped:focus:before,.tooltipped:focus:after{display:inline-block;text-decoration:none}.tooltipped-multiline:hover:after,.tooltipped-multiline:active:after,.tooltipped-multiline:focus:after{display:table-cell}.tooltipped-s:after,.tooltipped-se:after,.tooltipped-sw:after{top:100%;right:50%;margin-top:5px}.tooltipped-s:before,.tooltipped-se:before,.tooltipped-sw:before{top:auto;right:50%;bottom:-5px;margin-right:-5px;border-bottom-color:rgba(0,0,0,.8)}.tooltipped-se:after{right:auto;left:50%;margin-left:-15px}.tooltipped-sw:after{margin-right:-15px}.tooltipped-n:after,.tooltipped-ne:after,.tooltipped-nw:after{right:50%;bottom:100%;margin-bottom:5px}.tooltipped-n:before,.tooltipped-ne:before,.tooltipped-nw:before{top:-5px;right:50%;bottom:auto;margin-right:-5px;border-top-color:rgba(0,0,0,.8)}.tooltipped-ne:after{right:auto;left:50%;margin-left:-15px}.tooltipped-nw:after{margin-right:-15px}.tooltipped-s:after,.tooltipped-n:after{-webkit-transform:translateX(50%);-ms-transform:translateX(50%);transform:translateX(50%)}.tooltipped-w:after{right:100%;bottom:50%;margin-right:5px;-webkit-transform:translateY(50%);-ms-transform:translateY(50%);transform:translateY(50%)}.tooltipped-w:before{top:50%;bottom:50%;left:-5px;margin-top:-5px;border-left-color:rgba(0,0,0,.8)}.tooltipped-e:after{bottom:50%;left:100%;margin-left:5px;-webkit-transform:translateY(50%);-ms-transform:translateY(50%);transform:translateY(50%)}.tooltipped-e:before{top:50%;right:-5px;bottom:50%;margin-top:-5px;border-right-color:rgba(0,0,0,.8)}
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteIcons = document.querySelectorAll('.delete_pic i');

            deleteIcons.forEach(function (icon) {
                icon.addEventListener('click', function () {
                    const galleryPic = this.closest('.galleryPic');
                    if (galleryPic) {
                        galleryPic.remove();
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php require DIR_WS_INCLUDES . 'header.php'; ?>
<!-- header_eof //-->
<!-- body //-->
<div class="container-fluid">
    <h1><?php echo HEADING_TITLE; ?></h1>

    <div class="row">
    <div class="col-sm-12 col-md-6">
    <?php
    echo zen_draw_form('new_upload', FILENAME_ZX_IMAGE_MANAGER, 'action=insert', 'post', 'enctype="multipart/form-data" class="form-horizontal"');
    ?>

    <div class="form-group">
        <?php echo zen_draw_label(TEXT_UPLOAD_NEW_PIC, 'upload_pic', 'class="col-sm-3 control-label"'); ?>
        <div class="col-sm-9 col-md-9 col-lg-6">
            <?php echo zen_draw_file_field('upload_pic', '', 'class="form-control" id="upload_pic"'); ?>
        </div>
    </div>

    <?php
    $dir_info = zx_build_subdirectories_array(DIR_FS_CATALOG_IMAGES);
    $default_directory = '';
    ?>
    <div class="form-group">
        <?php echo zen_draw_label(TEXT_UPLOAD_DIR, 'img_dir', 'class="col-sm-3 control-label"'); ?>
        <div class="col-sm-9 col-md-9 col-lg-6">
            <?php echo zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory, 'class="form-control" id="img_dir"'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary"><?php echo IMAGE_INSERT; ?></button>
        </div>
    </div>
    <?php echo '</form>'; ?>
    </div>

    <div class="col-sm-12 col-md-6">
        <?php
        echo zen_draw_form('new_dir', FILENAME_ZX_IMAGE_MANAGER, 'action=new_dir', 'post', 'class="form-horizontal"');
        ?>

        <div class="form-group">
            <?php echo zen_draw_label(TEXT_CREATE_NEW_DIRECTORY, 'new_dir', 'class="col-sm-3 control-label"'); ?>
            <div class="col-sm-9 col-md-9 col-lg-6">
                <?php echo zen_draw_input_field('new_dir', '', 'class="form-control" id="new_dir"', true); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-primary"><?php echo IMAGE_CREATE; ?></button>
            </div>
        </div>

        <div class="bg-info p-2">
            <p><?php echo TEXT_NEW_DIR_INFO; ?></p>
        </div>

        <?php echo '</form>'; ?>

    </div>

    </div>

    <hr>

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
            <?php echo zen_draw_form('show_pics', FILENAME_ZX_IMAGE_MANAGER, 'action=show_pics', 'post', 'class="form-horizontal"'); ?>
            <h3><?php echo TEXT_BROWSE_IMAGES; ?></h3>
            <div class="form-group">
                <?php echo zen_draw_label(TEXT_SHOW_DIR, 'img_dir', 'class="col-sm-3 control-label"'); ?>
                <div class="col-sm-9 col-md-9 col-lg-6">
                    <?php echo zen_draw_pull_down_menu('img_dir', $dir_info, ($dir ?? $default_directory), 'class="form-control" id="img_dir"'); ?>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <button type="submit" class="btn btn-primary"><?php echo IMAGE_VIEW; ?></button>
                </div>
            </div>
            <?php echo '</form>'; ?>
        </div>

        <?php if($action == 'show_pics') { ?>
        <div class="col-12">
            <?php if(isset($message)) {
                echo $message;
            } else { ?>
            <h3>Displaying images in <?php echo $path; ?></h3>
            <div class="flexbox">
            <?php foreach ($fileList as $pic) {
                $dimensions = getimagesize($path.$pic);
                $filesize = number_format(filesize($path.$pic) / 1024, 1);
                $image_code = '<img src="images/'.$dir.$pic.'" alt="">';
                echo '<div class="col-xs-4 col-sm-3 col-md-2 galleryPic">';
                echo zen_info_image($dir . $pic, '', '', '', 'class="img-responsive"');
                echo '<div class="image_name">'.$pic.'</div>';
                echo '<div class="image_dimensions">' . $dimensions[0] . 'x' . $dimensions[1] . '</div>';
                echo '<div class="image_size">'.$filesize.' kB</div>';
                echo '<div class="input-group">
                <input id="foo" class="form-control" type="text" value="'.htmlspecialchars($image_code).'">
                    <span class="input-group-btn">
                        <a href="" class="clpbd" type="button" data-clipboard-text="'.htmlspecialchars($image_code).'">
                            <i class="fa-solid fa-copy fa-2x"></i>
                        </a>
                    </span>
                </div>';
                echo '</div>';
            }
            ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

    </div>

    <!-- body_text_eof //-->
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
