<?php

use craft\helpers\App;

$useDevServer = App::env('CRAFT_ENVIRONMENT') === 'dev' && App::env('VITE_USE_DEV_SERVER');

return [
    'checkDevServer' => $useDevServer,
    'devServerInternal' => 'http://localhost:5173/',
    'devServerPublic' => Craft::getAlias('@weburl') . ':5173',
    'errorEntry' => 'resources/js/app.js',
    'manifestPath' => Craft::getAlias('@webroot') . '/dist/assets/.vite/manifest.json',
    'serverPublic' => Craft::getAlias('@weburl')  . '/dist/assets/',
    'useDevServer' => $useDevServer,
    'includeModulePreloadShim' => true,
    'includeScriptOnloadHandler' => false,
];
