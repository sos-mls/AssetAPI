<?php

/**
 * Contains the DeleteController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.traits.ErrorResponse');

use Common\ApiController;

/**
 * The DeleteController states which assets are to be collected in garbage.
 *
 * Places assets in a listing of assets that denote deletion.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class DeleteController extends ApiController
{
    use ErrorResponse;

    /**
     * Goes to remove the asset from the current DB.
     *
     * An asset is only removed through garbage collection, the delete/asset process is there
     * to flag the asset for garbage collection.
     *
     * @return JSON If the file has been deleted or not.
     */
    public function actionAsset()
    {
        $hash_id = $this->getHashID('delete/asset');
        if ($hash_id != "" ) {
            if (Asset::model()->fileName($hash_id)->exists()) {
                $asset = Asset::model()->fileName($hash_id)->find();

                $asset->is_used = Asset::IS_NOT_USED;
                $asset->save();

                $this->renderJSON([
                    'success' => "Asset will be deleted."
                ]);
            } else {
                $this->error_response("Asset not found.");
            }
        } else {
            $this->error_response("Not a proper http method type, please send the asset file_name");
        }
    }
}