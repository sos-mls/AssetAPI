<?php

/**
 * Contains the Document class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

Yii::import('application.models._base.BaseDocument');

/**
 * The Document class.
 *
 * Contains the size, and name of the document.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class Document extends BaseDocument
{
	public static function model($className=__CLASS__) {
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
     * Gets the URL to the document.
     *
     * @return string The document URL.
     */
    public function getURL()
    {
        return Yii::app()->params->relative_document_dir . $this->file_name;
    }

    /**
     * Converts all of the document information to an array
     *
     * @return array All of the document information.
     */
    public function toArray()
    {
        return [
            'public_url' => $this->getURL(),
            'file_name'  => $this->file_name,
            'file_size'  => $this->file_size,
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
     * @return Document          A reference to this.
     */
    public function fileName($file_name)
    {
        $this->getDbCriteria()->compare('t.file_name', $file_name);
        return $this;
    }
}