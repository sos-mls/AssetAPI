<?php

/**
 * Contains the CreateController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\ApiController;
use Asset\Action\Image as Action_Image;
use Asset\File\Image as File_Image;
use Asset\Action\Document as Action_Document;
use Asset\File\Document as File_Document;
use Common\File;
use Common\File\NotFoundException;
use Common\File\NotSafeException;
use Common\File\NotValidException;

/**
 * The CreateController Saves the current file
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class CreateController extends ApiController
{
    /**
     * Saves the given file to the local assets directory, with a random filename associated
     * with it. It then returns the random file name, or if the file could not have been saved.
     *
     * @return JSON     The name of the file or the error if one occured.
     */
    public function actionIndex()
    {
        if (!empty($_FILES)) {
            try {
                $actions = Yii::app()->params->asset_library['actions'];
                if (array_key_exists('actions', $_POST) && is_array($_POST['actions'])) {
                    $actions = $_POST['actions'];
                }

                $absolute_path = $_FILES['file']['tmp_name'];
                $file_name = $_FILES['file']['name'];

                // Create image file here
                if (AssetType::getType($absolute_path) == AssetType::IMAGE)
                {
                    $action_results = File_Image::forge(
                        $_FILES['file']['tmp_name'],
                        Yii::app()->params->asset_library['valid_image_types'],
                        $actions
                    )->act();
                } else if (AssetType::getType($absolute_path, $file_name) == AssetType::DOCUMENT) {
                    $action_results = File_Document::forge(
                        $_FILES['file']['tmp_name'],
                        Yii::app()->params->asset_library['valid_document_types'],
                        $actions
                    )->act();
                }

                $asset = $this->createAsset();

                if ($asset->assetType->asset_type == AssetType::IMAGE) {
                    $this->createImages($asset, $action_results);
                } else if ($asset->assetType->asset_type == AssetType::DOCUMENT) {
                    $this->createDocuments($asset, $action_results);
                }

                if (sizeof($asset->getErrors()) == 0) {
                    $this->renderJSON($asset->toArray());
                } else {
                    $this->renderJSON([
                        'errors' => $asset->getErrors()
                    ]);
                }
            } catch (Exception $e) {
                $this->renderJSONError($e->getMessage(), 200);
            }
        } else {
            $this->renderJSONError("Not a proper http method type, please send a FILE");
        }
    }

    /**
     * Goes to create an asset from the current file.
     *
     * Creates an asset from the given file, get the asset type, creates a unique name
     * for the asset, and saves it.
     *
     * @return Asset The asset created from the file given.
     */
    private function createAsset()
    {
        $asset_type = AssetType::getType($_FILES['file']['tmp_name']);
        $destination = Asset::generateDestination();
        $name = Asset::getAssetName($destination);

        $asset = new Asset();
        $asset->asset_type_id = $asset_type->asset_type_id;
        $asset->file_name = $name;
        $asset->uploaded_name = $_FILES['file']['name'];
        $asset->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
        $asset->save();

        return $asset;
    }

    /**
     * Creates a list of images from the given asset and the action results on the file.
     *
     * Runs through all of the action results to get the path of the acted on file and move
     * it to the desired destination. It saves information about the new image (width, height,
     * size, ...) and assocaites it with the given asset.
     *
     * @param  Asset  &$asset         A reference to the created Asset.
     * @param  array  $action_results The results of the action on the file.
     */
    private function createImages(Asset &$asset, array $action_results = [])
    {
        foreach ($action_results as $action_result) {
            $destination = Asset::generateDestination();
            $name = Asset::getAssetName($destination);

            if (!rename($action_result[Action_Image::PATH_KEY], $destination)) {
                $this->renderJSONError("Could not save the image. Please Try again.");
            }

            $image = new Image();
            $image->asset_id = $asset->asset_id;
            $image->file_name = $name;
            $image->file_size = filesize($destination);
            list($image->width, $image->height) = getimagesize($destination);
            $image->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
            $image->save();

            $asset->addErrors($image->getErrors());
        }
    }

    /**
     * Creates a list of documents from the given assets and action results on the file.
     *
     * Runs through all of the action results to get the path of the acted on file and move
     * it to the desired destination. It saves information about the new document (name and size)
     * and associates it with the given asset.
     * 
     * @param  Asset  &$asset         A reference to the recently created asset.
     * @param  array  $action_results The results of the action on the file.
     */
    private function createDocuments(Asset &$asset, array $action_results = [])
    {
        foreach ($action_results as $action_result) {
            $destination = Asset::generateDestination();
            $name = Asset::getAssetName($destination);

            if (!rename($action_result[Action_Document::PATH_KEY], $destination)) {
                $this->renderJSONError("Could not save the document. Please Try again.");
            }

            $document = new Document();
            $document->asset_id = $asset->asset_id;
            $document->file_name = $name;
            $document->file_size = filesize($destination);
            $document->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
            $document->save();

            $asset->addErrors($document->getErrors());
        }
    }
}
