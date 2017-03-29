<?php

/**
 * Cleans up the given image to be usable in all front end applications
 */
class CleanImage extends CApplicationComponent {
	
	const MAX_SIZE = 1000;

	/**
	 * Goes to clean the image by converting it to a png.
	 * 
	 * @param  string $absolute_file_path The file path of the image on the server.
	 */
	public static function clean($absolute_file_path) {
		$img = new Imagick($absolute_file_path);
		self::convertToPNG($img);
		self::autorotate($img);
		self::scaleImage($img);
		$img->writeImage();
	}

	/**
	 * Rotates the image to the proper orientation and saves it as a png.
	 * 
	 * @param string $absolute_file_path The absolute file path on the server.
	 */
	private static function convertToPNG(Imagick &$img)  {
		$img->stripImage(); // if you want to get rid of all EXIF data
		$img->setImageFormat("png");
		$img->setImageCompressionQuality(100);
	}

	/**
	 * Calculate new image dimensions to new constraints
	 *
	 * @param  Imagick  &$img [description]
	 */
	private static function scaleImage(Imagick &$img)  {
	   	$height = ($img->getImageHeight() > self::MAX_SIZE) ? self::MAX_SIZE : $img->getImageHeight();
	   	$width = ($img->getImageWidth() > self::MAX_SIZE) ? self::MAX_SIZE : $img->getImageWidth();

		//Scale the image
		$img->thumbnailImage($width, $height, true);
	}

	/**
	 * Auto orientate the image to the proper size.
	 * 
	 * @param  Imagick $image [description]
	 * @return [type]         [description]
	 */
	private static function autorotate(Imagick &$image) {
	    switch ($image->getImageOrientation())  {
		    case Imagick::ORIENTATION_TOPLEFT:
		        break;
		    case Imagick::ORIENTATION_TOPRIGHT:
		        $image->flopImage();
		        break;
		    case Imagick::ORIENTATION_BOTTOMRIGHT:
		        $image->rotateImage("#000", 180);
		        break;
		    case Imagick::ORIENTATION_BOTTOMLEFT:
		        $image->flopImage();
		        $image->rotateImage("#000", 180);
		        break;
		    case Imagick::ORIENTATION_LEFTTOP:
		        $image->flopImage();
		        $image->rotateImage("#000", 270);
		        break;
		    case Imagick::ORIENTATION_RIGHTTOP:
		        $image->rotateImage("#000", 90);
		        break;
		    case Imagick::ORIENTATION_RIGHTBOTTOM:
		        $image->flopImage();
		        $image->rotateImage("#000", 90);
		        break;
		    case Imagick::ORIENTATION_LEFTBOTTOM:
		        $image->rotateImage("#000", 270);
		        break;
		    default: // Invalid orientation
		        break;
	    }

	    $image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);
	}
}
