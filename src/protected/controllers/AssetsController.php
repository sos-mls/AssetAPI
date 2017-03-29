<?php


Yii::import('application.traits.ErrorResponse');
Yii::import('application.traits.FileVerifier');

/**
 * The AssetsController is there for file handling and controls basic creates and read for all files given.
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class AssetsController extends ApiController
{
	use ErrorResponse;
	use FileVerifier;

	const DEFAULT_LAYOUT = 'default';

	public $layout = self::DEFAULT_LAYOUT;

	/**
	 * A general response for the user to understand where to get information about interfacing with the API.
	 * 
	 * @return [type] [description]
	 */
	public function actionIndex() {
		$this->renderJSON([
			'info' => 'https://bitbucket.org/scooblyboo/assetsapi'
		]);
	}

	/**
	 * Saves the given file to the local assets directory, with a random filename associated
	 * with it. It then returns the random file name, or if the file could not have been saved.
	 * 
	 * @return JSON 	The name of the file or the error if one occured.
	 */
	public function actionSave() {
		if (!empty($_FILES)) {
			try {
				$destination = Asset::generateDestination();
				$name = Asset::getAssetName($destination);

				if (!$this->is_file_safe($_FILES['file']['tmp_name'])) {
					$this->error_response("This is an unsecure file and cannot be used. Try again.");
				}

				if (!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
					$this->error_response("Could not upload the file. Please Try again.");
				} 

				CleanImage::clean($destination);

				$asset = new Asset();
				$asset->asset_type_id = AssetType::getType($destination)->asset_type_id;
				$asset->file_name = $name;
				$asset->file_size = filesize($destination);
				$asset->uploaded_name = $_FILES['file']['name'];
				$asset->created_at = str_replace("+0000", "Z", date(DATE_ISO8601, getdate()[0]));
				

				$this->renderJSON([
					'is_saved' => $asset->save(),
					'name' => $name,
					'url' => $asset->getURL(),
					'errors' => $asset->getErrors()
				]);
			} catch (Exception $e) {
				$this->error_response($e->getTrace(), 500);
			}
		} else {
			$this->error_response("Not a proper http method type, please send a FILE");
		}
	}

	/**
	 * Reads the contents of the file from the given filename.
	 *  
	 * @return string The contents of the file.
	 */
	public function actionRead() {
		if ($_GET['name']) {
			if ($asset = Asset::model()->fileName($_GET['name'])->exists()) {
				$absolute_file_path = Asset::getAssetDir() . $_GET['name'];
				$this->set_header($absolute_file_path);
				
				$result = file_get_contents($absolute_file_path);
				echo $result;
			} else {
				$this->error_response("File not found.");
			}
		} else {
			$this->error_response("Not a proper http method type, please send a GET with a name");
		}
	}

	/**
	 * Goes to remove the file and delete the asset associated with that file.
	 * 
	 * @return JSON If the file has been deleted or not.
	 */
	public function actionRemove() {
		if ($_POST['name']) {

			$asset = Asset::model()->fileName($_POST['name'])->find();
			if ($asset->isAssociated()) {
				$this->renderJSON([
					'success' => "File will be deleted later."
				]);

				return;
			}

			// only remove this file if its not already associated with an element
			unlink(Asset::getAssetDir() . $_POST['name']);

			if (!is_null($asset)) {
				$asset->delete();	

				$this->renderJSON([
					'success' => "File deleted."
				]);	
			} else {
				$this->error_response("File not found.");
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
	private function set_header($absolute_file_path) {
		header('Cache-control: max-age='.(60*60*24*365));
		header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*365));
		header('Last-Modified: '.gmdate(DATE_RFC1123,filemtime($absolute_file_path)));
		header('Content-Type: ' . mime_content_type($absolute_file_path));
	}
}
