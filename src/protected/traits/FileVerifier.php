<?php

/**
 * Checks to see if a file given is safe.
 */
trait FileVerifier 
{

	/**
	 * Checks to see if the file passes safety standards as given by:
	 * 		
	 * 		http://php.net/manual/en/function.move-uploaded-file.php#111412
	 * 		
	 * @param  string  $file_path The path of the file to be uploaded
	 * @return boolean            If the file is safe or not.
	 */
	private function is_file_safe($file_path) 
	{
		return (filesize($file_path) > 0)
			&& !$this->check_file_uploaded_name($file_path)
			&& !$this->check_file_uploaded_length($file_path);
	}

	/**
	 * Check $_FILES[][name]
	 *
	 * @param  string $filename Uploaded file name.
	 * @return boolean          That the file_upload_name valid.
	 * @author Yousef Ismaeil Cliprz
	 */
	private function check_file_uploaded_name ($filename)
	{
	    return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? true : false);
	}

	/**
	 * Check $_FILES[][name] length.
	 *
	 * @param  string $filename Uploaded file name.
	 * @return boolean          That the file_upload_length valid.
	 * @author Yousef Ismaeil Cliprz.
	 */
	private function check_file_uploaded_length ($filename = "")
	{
	    return (bool) ((mb_strlen($filename,"UTF-8") > 225) ? true : false);
	}
}