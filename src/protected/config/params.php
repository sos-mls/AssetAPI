<?php

// this contains the application parameters that can be maintained via GUI

return array(
	// this is displayed in the header section
	'title' => 'Skeleton',

	// the login duration when a user selects 'remember me'
	'loginDuration' => 3600 * 24 * 30, // 30 days

	// this is used in error pages
	'adminEmail' => 'services@skeleton.com',

	// the copyright information displayed in the footer section
	'copyrightInfo' => 'Copyright &copy; 2016 by Sale Cents',

	// The date format used by the database
	'dbDateFormat' => 'Y-m-d H:i:s'
);
