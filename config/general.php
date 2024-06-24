<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

$cpTrigger = 'admin';
$isCpRequest = str_starts_with($_SERVER['REQUEST_URI'], "/$cpTrigger") || str_starts_with($_GET['p'], $cpTrigger);

// Can't use Craft's functionality here because it's not available before being configured...
// This has to match the way site URLs are set up via .env/site settings (maybe this logic has to be environment-specific).

$pageTrigger = match (substr($_SERVER['REQUEST_URI'], 0, 4)) {
    '/de/' => '?seite=',
    default => '?page=',
};

$isDev = App::env('CRAFT_ENVIRONMENT') === 'dev';
$isProd = App::env('CRAFT_ENVIRONMENT') === 'production';



return GeneralConfig::create()
	->defaultWeekStartDay(1)
	->omitScriptNameInUrls()
	->cpTrigger($cpTrigger)
    ->pageTrigger($pageTrigger)
	->devMode($isDev)
    ->preloadSingles()
	->allowAdminChanges($isDev)
	->preventUserEnumeration()
	->disallowRobots(!$isProd)
	->maxRevisions(3)
	->convertFilenamesToAscii()
	->limitAutoSlugsToAscii()
	->generateTransformsBeforePageLoad(!$isCpRequest)
	->optimizeImageFilesize(false)
	->revAssetUrls()
    ->transformGifs(false)
    ->transformSvgs(false)
    ->tempAssetUploadFs('internalFs')
	->enableTemplateCaching($isProd)
    ->translationDebugOutput(false)
	->aliases([
		// Prevent the @web alias from being set automatically (avoid cache poisoning vulnerability)
		'@web' => App::env('PRIMARY_SITE_URL'),

		// Lets `./craft clear-caches all` clear CP resources cache
		'@webroot' => dirname(__DIR__) . '/web',

	]);
