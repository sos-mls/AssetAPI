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
     * Goes through all of the current assets that are not used over
     * a certain time period, deletes all of their files and then delete
     * their instance in the DB.
     */
    private function runGarbageCollection()
    {
        $garbage_assets = Asset::model()->notUsedGarbage()->findAll();
        foreach ($garbage_assets as $asset) {
            $asset->deleteFiles();
            $asset->delete();
        }
    }
}