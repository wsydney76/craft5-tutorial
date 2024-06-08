<?php

namespace modules\main\controllers;

use craft\elements\Entry;
use craft\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Entries controller
 */
class EntriesController extends Controller
{
    public $defaultAction = 'index';
    protected array|int|bool $allowAnonymous = true;

    /**
     * main/entries action
     */
    public function actionContent(int $id): Response
    {
        $entry = Entry::findOne($id);
        if (!$entry) {
            throw new NotFoundHttpException('Image not found');
        }

        return $this->renderTemplate('_entries/content', [
            'entry' => $entry,
        ]);
    }
}
