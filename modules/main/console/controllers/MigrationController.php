<?php

namespace modules\main\console\controllers;

use Craft;
use craft\console\Controller;
use craft\elements\Entry;
use craft\helpers\Console;
use GuzzleHttp\Exception\GuzzleException;
use yii\console\ExitCode;


class MigrationController extends Controller
{
    /**
     * Checks all live entries for runtime errors
     *
     * craft main/migration/check-runtime-errors
     *
     * @return int
     */
    public function actionCheckRuntimeErrors(): int
    {
        Console::output("Checking all live entries for runtime errors...");

        $entries = Entry::find()
            ->uri(':notempty:')
            ->site('*')
            ->all();

        $client = Craft::createGuzzleClient();

        $errors = 0;
        $ok = 0;
        $has403 = false;
        $messages = [];

        $totalEntries = count($entries);
        Console::startProgress(0, $totalEntries, 'Checking...');

        foreach ($entries as $index => $entry) {

            Console::updateProgress($index + 1, $totalEntries, "Checking, found $errors error(s) so far.");

            $url = $entry->url;

            try {
                $response = $client->get($url);
            } catch (GuzzleException $e) {
                $statusCode = $e->getCode();
                if ($statusCode === 403) {
                    $has403 = true;
                } else {
                    $messages[] = "Error: $url returned $statusCode";
                    $errors++;
                }
                continue;
            }

            // All errors should be caught by the try/catch block, but who knows...
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                $errors++;
                $messages[] = "Error: $url returned $statusCode";
                continue;
            }

            $ok++;
        }

        Console::endProgress();

        foreach ($messages as $message) {
            Console::output($message);
        }

        if ($has403) {
            Console::output("Some URLs are protected and could not be checked.");
        }

        Console::output("$ok URLs without runtime error.");

        if ($errors > 0) {
            Console::output("$errors runtime errors found.");
        } else {
            Console::output("No runtime errors found. Don't rejoice too soon.");
        }

        return ExitCode::OK;
    }

    public function actionConsolidateFieldsCandidates()
    {
        $signatures = [];

        foreach (Craft::$app->getFields()->getAllFields() as $field) {
            $signature = [
                'type' => get_class($field),
                'translationMethod' => $field->translationMethod,
                'translationKeyFormat' => $field->translationKeyFormat,
                'searchable' => $field->searchable,
                'settings' => $field->settings,
            ];

            $hash = md5(json_encode($signature));

            $signatures[$hash][] = $field->handle;

        }
        foreach ($signatures as $hash => $handles) {
            if (count($handles) > 1) {
                Console::output( implode(', ', $handles));
            }
        }
    }
}