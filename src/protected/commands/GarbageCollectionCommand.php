<?php

/**
 * Contains the GarbageCollectionCommand class.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

/**
 * The GarbageCollectionCommand deletes all unused assets.
 *
 * Runs through all of the assets that are unused and old enough for garbage
 * collection and then deletes them.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class GarbageCollectionCommand extends CConsoleCommand 
{

    /**
     * Runs the garbage collection function.
     */
    public function run($args) 
    {
        $this->runGarbageCollection();
    }

    /**
     * Deletes all of the assets and their files.
     *
     * 
     */
    private function runGarbageCollection() 
    {
        $garbage_assets = Asset::model()->notUsedGarbage()->findAll();
        foreach ($garbage_assets as $asset) 
        {
            $asset->deleteFiles();
            $asset->delete();
        }
    }
}