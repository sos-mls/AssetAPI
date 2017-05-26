
<?php

/**
 * Contains the UseController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.traits.ErrorResponse');

use Common\ApiController;

/**
 * The UseController determines what assets are to be saved in the system.
 *
 * Keeps track of assets that are used if the assets have not been deleted yet.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class UseController extends ApiController
{
    use ErrorResponse;
    /**
     * Marks the given file name as IS_USED.
     *
     * Checks to see that the asset exists, if so then the asset will not be deleted in
     * the garbage collection process and stored until the asset is to be deleted.
     */
    public function actionAsset()
    {
        $hash_id = $this->getHashID('use/asset');
        if ($hash_id !== "") {
            if (Asset::model()->fileName($hash_id)->exists()) {
                $asset = Asset::model()->fileName($hash_id)->find();

                $asset->is_used = Asset::IS_USED;
                $asset->save();

                $this->renderJSON([
                    'success' => "Asset is now used."
                ]);
            } else {
                $this->error_response("Asset not found.");
            }
        } else {
            $this->error_response("Please send the asset file_name");
        }
    }
}