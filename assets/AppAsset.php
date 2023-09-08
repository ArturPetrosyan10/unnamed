<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //plugins for menu
        'css/plugins/fontawesome-free/css/all.min.css',
        'css/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        'css/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        'css/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
        'css/dist/css/adminlte.min.css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
    ];
    public $js = [
//        'https://code.jquery.com/jquery-3.6.0.min.js',
        'https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js',
        //for charts
        'css/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'css/plugins/chart.js/Chart.min.js',
        'css/dist/js/adminlte.min.js',
        'css/dist/js/demo.js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',

        'js/app.js?v=10',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
