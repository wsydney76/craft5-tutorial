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

// Site specific page trigger: ?seite= for German, ?page= for English
// Can't use Craft's functionality here because it's not available before being configured...
// This has to match the way site URLs are set up via .env/site settings (maybe this logic has to be environment-specific).

$pageTrigger = match (substr($_SERVER['REQUEST_URI'], 0, 4)) {
    '/de/' => '?seite=',
    default => '?page=',
};

$isDev = App::env('CRAFT_ENVIRONMENT') === 'dev';
$isProd = App::env('CRAFT_ENVIRONMENT') === 'production';



return GeneralConfig::create()
	->allowAdminChanges($isDev)
	->convertFilenamesToAscii()
	->cpTrigger($cpTrigger)
	->defaultWeekStartDay(1)
	->devMode($isDev)
	->disallowRobots(!$isProd)
	->enableTemplateCaching($isProd)
	->generateTransformsBeforePageLoad(!$isCpRequest)
	->limitAutoSlugsToAscii()
	->maxRevisions(3)
	->omitScriptNameInUrls()
	->optimizeImageFilesize(false)
	->preventUserEnumeration()
	->revAssetUrls()
    ->pageTrigger($pageTrigger)
    ->preloadSingles()
    ->resourceBasePath('@webroot/dist/cpresources/')
    ->resourceBaseUrl('@weburl/dist/cpresources/')
    ->transformGifs(false)
    ->transformSvgs(false)
    ->translationDebugOutput(false)

	->aliases([

        // Prevent the @web alias from being set automatically (cache poisoning vulnerability)
        // The @web alias is not recommended and not used, setting it here to avoid warnings in CP
        '@web' => App::env('PRIMARY_SITE_URL'),

        // Use this as a base url for sites/local filesystems
        '@weburl' => App::env('PRIMARY_SITE_URL'),

		// Lets `./craft clear-caches all` clear CP resources cache
		'@webroot' => dirname(__DIR__) . '/web',

	]);
