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
    public function actionIndex()
    {
        $this->renderJSON([
            'api' => [
                'create' => 'https://github.com/sos-mls/AssetAPI/wiki/API-Create',
                'use'    => 'https://github.com/sos-mls/AssetAPI/wiki/API-Use',
                'read'   => 'https://github.com/sos-mls/AssetAPI/wiki/API-Read',
                'delete' => 'https://github.com/sos-mls/AssetAPI/wiki/API-Delete',
            ],
            'settings' => 'https://github.com/sos-mls/AssetAPI/wiki/Settings',
            'testing' => 'https://github.com/sos-mls/AssetAPI/wiki/Testing'
        ]);
    }
}
