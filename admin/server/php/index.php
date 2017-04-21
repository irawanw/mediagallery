<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
session_write_close();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 0);
require('UploadHandler.php');
$upload_handler = new UploadHandler();

