<?php


Yii::import('application.traits.ErrorResponse');

use Common\ApiController;

/**
 * The RemoveController removes the given 
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class RemoveController extends ApiController
{
    use ErrorResponse;

    /**
     * Goes to remove the asset from the current DB.
     * 
     * @return JSON If the file has been deleted or not.
     */
    public function actionAsset() {
        $hash_id = $this->getHashID('remove/asset');
        if ($hash_id !== "") {
            if (Asset::model()->fileName($hash_id)->exists()) {
                $asset = Asset::model()->fileName($hash_id)->find();

                $asset->is_used = Asset::IS_NOT_USED;
                $asset->save();

                $this->renderJSON([
                    'success' => "File will be deleted."
                ]);
            }
        } else {
            $this->error_response("Not a proper http method type, please send the asset file_name");
        }
    }
}