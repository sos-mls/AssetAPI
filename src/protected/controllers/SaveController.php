<?php


Yii::import('application.traits.ErrorResponse');

use Common\ApiController;
use Asset\Action\Image as Action_Image;
use Asset\File\Image as File_Image;
use Common\File\NotFoundException;
use Common\File\NotSafeException;
use Common\File\NotValidException;

/**
 * The SaveController Saves the current file 
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class SaveController extends ApiController
{
    use ErrorResponse;

    /**
     * Saves the given file to the local assets directory, with a random filename associated
     * with it. It then returns the random file name, or if the file could not have been saved.
     *
     * @return JSON     The name of the file or the error if one occured.
     */
    public function actionIndex() {
        if (!empty($_FILES)) {
            try {

                // Create file here
                $action_results = File_Image::forge(
                    $_FILES['file']['tmp_name'], 
                    Yii::app()->params->asset_library['valid_types'],
                    Yii::app()->params->asset_library['actions']
                )->act();

                $asset = $this->createAsset();

                if ($asset->assetType->asset_type == AssetType::IMAGE) {
                    $this->createImages($asset, $action_results);
                }

                if (sizeof($asset->getErrors()) == 0) {
                    $this->renderJSON($asset->toArray());
                } else {
                    $this->renderJSON([
                        'errors' => $asset->getErrors()
                    ]);
                }
            } catch (Exception $e) {
                $this->error_response($e->getTrace(), 500);
            }
        } else {
            $this->error_response("Not a proper http method type, please send a FILE");
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
    private function createAsset() {
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
    private function createImages(Asset &$asset, array $action_results = []) {
        foreach ($action_results as $action_result) {
            $destination = Asset::generateDestination();
            $name = Asset::getAssetName($destination);

            if (!rename($action_result[Action_Image::PATH_KEY], $destination)) {
                $this->error_response("Could not save the image. Please Try again.");
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
}
