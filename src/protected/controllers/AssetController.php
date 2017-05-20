<?php

/**
 * Contains the AssetController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

use Common\ApiController;

/**
 * The AssetController Acts as a default controller.
 *
 * It sends the user to the given pages to get more information about how to utilize
 * the Asset Api.
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class AssetController extends ApiController
{
    /**
     * A general response for the user to get information
     *
     * The response contains where to get general information about the AssetApi,
     * how to utilize the AssetApi, Configuration of the AssetApi, and Recommendations
     * for integrating the assetApi into a server network.
     */
    public function actionIndex() {
        $this->renderJSON([
            'info' => 'https://bitbucket.org/scooblyboo/assetapi',
            'local_asset_dir' => Yii::app()->params
        ]);
    }
}
