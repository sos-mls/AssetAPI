<?php

/**
 * Contains the ReadController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.traits.ErrorResponse');

use Common\ApiController;

/**
 * The ReadController is there for reading the given files referenced on this server.
 *
 * Allows for reads of images and assets where an asset response contains a json of
 * the generic information about the asset and its references. The image response 
 * contains the contents of the file.
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class ReadController extends ApiController
{
    use ErrorResponse;

    /**
     * Gets Asset information about the requested file. 
     *
     * Simply converts the asset to an array if the asset exists in the system.
     *  
     * @return string The contents of the file.
     */
    public function actionAsset() {
        $hash_id = $this->getHashID('read/asset');
        if ($hash_id !== "") {
            if (Asset::model()->fileName($hash_id)->exists()) {
                $asset = Asset::model()->fileName($hash_id)->find();
                $this->renderJSON($asset->toArray());
            } else {
                $this->error_response("Asset not found.");
            }
        } else {
            $this->error_response("Not a proper http method type, please send a GET with a name");
        }
    }

    /**
     * Reads the contents of the image from the given filename.
     *
     * Checks to see that the image's fileName currently exists, if so then it
     * gets the absolute file path to the image and gets the contents of that 
     * image.
     *  
     * @return string The contents of the image.
     */
    public function actionImage() {
        $hash_id = $this->getHashID('read/image');
        if ($hash_id !== "") {
            if (Image::model()->fileName($hash_id)->exists()) {
                $absolute_file_path = Asset::getAssetDir() . $hash_id;
                $this->setHeader($absolute_file_path);
                
                echo file_get_contents($absolute_file_path);
            } else {
                $this->error_response("Image not found.");
            }
        } else {
            $this->error_response("Not a proper http method type, please send a GET with a name");
        }
    }

    /**
     * Sets the proper header for the assets that is being read.
     * 
     * @param string $absolute_file_path The absolute file path on the server.
     */
    private function setHeader($absolute_file_path) {
        header('Cache-control: max-age=' . (60*60*24*365));
        header('Expires: ' . gmdate(DATE_RFC1123,time()+60*60*24*365));
        header('Last-Modified: ' . gmdate(DATE_RFC1123,filemtime($absolute_file_path)));
        header('Content-Type: ' . mime_content_type($absolute_file_path));
    }
}
