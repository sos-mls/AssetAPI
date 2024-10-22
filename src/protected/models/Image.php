<?php

/**
 * Contains the Image class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseImage');

/**
 * The Image class.
 *
 * Contains the width, height, size, and name of the image.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class Image extends BaseImage
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     *
     * Object Methods
     *
     *
     */

    /**
     * Gets the URL to the image.
     *
     * @return string The image URL.
     */
    public function getURL()
    {
        return Yii::app()->params->relative_image_dir . $this->file_name;
    }

    /**
     * Converts all of the image information to an array
     *
     * @return array All of the image information.
     */
    public function toArray()
    {
        return [
            'public_url' => $this->getURL(),
            'file_name'  => $this->file_name,
            'file_size'  => $this->file_size,
            'width'      => $this->width,
            'height'     => $this->height,
            'created_at' => $this->created_at,
        ];
    }

    /**
     *
     *
     * Scopes
     *
     *
     */

    /**
     * Filters criteria by file_name.
     *
     * @param  string $file_name The file name to filter by.
     * @return Image             A reference to this.
     */
    public function fileName($file_name)
    {
        $this->getDbCriteria()->compare('t.file_name', $file_name);
        return $this;
    }
}