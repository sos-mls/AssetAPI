<?php

/**
 * Contains the ReadController class.
 *
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

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
    const IMG_HASH_ID_CLEAN_REGEX = "/(\.jpg)|(\.png)|(\.gif)/";

    /**
     * Gets Asset information about the requested file.
     *
     * Simply converts the asset to an array if the asset exists in the system.
     *
     * @return string The contents of the file.
     */
    public function actionAsset()
    {
        $hash_id = $this->getHashID('read/asset');
        if ($hash_id != "") {
            if (Asset::model()->fileName($hash_id)->exists()) {
                $asset = Asset::model()->fileName($hash_id)->find();
                $this->renderJSON($asset->toArray());
            } else {
                $this->renderJSONError("Asset not found.");
            }
        } else {
            $this->renderJSONError("Please send the asset file_name");
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
    public function actionImage()
    {
        $hash_id = $this->cleanHashID($this->getHashID('read/image'));
        if ($hash_id != "") {
            if (Image::model()->fileName($hash_id)->exists()) {
                $absolute_file_path = Asset::getAssetDir() . $hash_id;
                $this->setHeader($absolute_file_path);
                
                echo file_get_contents($absolute_file_path);
            } else {
                $this->renderJSONError("Image not found.");
            }
        } else {
            $this->renderJSONError("Please send the image file_name");
        }
    }

    /**
     * Reads the contents of the document from the given filename.
     *
     * Checks to see that the documents's fileName currently exists, if so then it
     * gets the absolute file path to the document and gets the contents of that
     * document.
     *
     * @return string The contents of the document.
     */
    public function actionDocument()
    {
        $hash_id = $this->cleanHashID($this->getHashID('read/document'));
        if ($hash_id != "") {
            if (Document::model()->fileName($hash_id)->exists()) {
                $absolute_file_path = Asset::getAssetDir() . $hash_id;
                $this->setHeader($absolute_file_path);
                
                echo file_get_contents($absolute_file_path);
            } else {
                $this->renderJSONError("Document not found.");
            }
        } else {
            $this->renderJSONError("Please send the document file_name");
        }
    }

    /**
     * Sets the proper header for the assets that is being read.
     *
     * @param string $absolute_file_path The absolute file path on the server.
     */
    private function setHeader($absolute_file_path)
    {
        $this->generateHeader('Cache-control: max-age=' . (60*60*24*365));
        $this->generateHeader('Expires: ' . gmdate(DATE_RFC1123, time()+60*60*24*365));
        $this->generateHeader('Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($absolute_file_path)));
        $this->generateHeader('Content-Type: ' . mime_content_type($absolute_file_path));
    }

    /**
     * Goes to remove generic image file extensions from the given hash_id, therefore
     * "cleaning" it.
     *
     * @param  string $hash_id A hash ID from the request.
     * @return string          A clean hash id.
     */
    private function cleanHashID($hash_id = "")
    {
        return preg_replace(self::IMG_HASH_ID_CLEAN_REGEX, "", $hash_id);
    }
}
