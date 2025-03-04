<?php

/**
 * Contains the QueryController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\ApiController;

/**
 * The QueryController is there for querying file information referenced on this server.
 *
 * Allows for querying an asset based off of the attributes of the asset. The assets
 * should be queryable by the file_name, type, creation time and its current usage.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class QueryController extends ApiController
{
    /**
     * Gets Asset information about the requested file.
     *
     * Simply converts the asset to an array if the asset exists in the system.
     *
     * @return string The contents of the file.
     */
    public function actionAsset()
    {
        if ($this->validAssetGet()) {
            $model = Asset::model();
            foreach (Yii::app()->params->query_expected_asset_keys as $key) {
                if (isset($_GET[$key]) && sizeof($_GET[$key]) > 0 ) {
                    $model->{Yii::app()->params->query_asset_scope_functions[$key]}($_GET[$key]);
                }
            }
            $assetObjects = $model->findAll();
            $assetJSONs = [];
            foreach ($assetObjects as $asset) {
                $assetJSONs[] = $asset->toArray();
            }

            $this->renderJSON($assetJSONs);
        } else {
            $this->renderJSONError("Please send a valid GET. Include type, uploaded_name or is_used");
        }
    }

    /**
     * Checks to see if the current GET is valid based off of the assets attributes.
     *
     * @return boolean         If the GET is currently valid.
     */
    private function validAssetGet()
    {
        $valid = false;
        foreach (Yii::app()->params->query_expected_asset_keys as $key) {
            if (array_key_exists($key, $_GET)) {
                $valid = true;
            }
        }
        return $valid;
    }
}
