<?php
/**
 * Created by PhpStorm.
 * User: mains2114
 * Date: 14-12-28
 * Time: 下午8:50
 */

require_once 'include.php';
require_once 'database.php';
require_once 'session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'):
	echo 'current time: ', time(), '<br>';
	echo 'this is a post request', '<br>';
	if ( isset($_FILES['file']) && $_FILES['file']['error'] == 0 ) {
		$name = Input::post('name');
		$type = Input::post('type');

		$upload_file = $_FILES['file'];
		$md5 = md5_file($upload_file['tmp_name']);
		$source = md5( $md5.time().$upload_file['tmp_name'] );

		// check whether file is exist by judge its md5
		//
		$sql = "SELECT COUNT(*) AS num FROM resource WHERE md5 = '{$md5}'";
		$query = $db->query($sql);
		$result = $query->fetch(PDO::FETCH_ASSOC);

		if ($result['num'] > 0) {
			exit('File already exist!');
		}

		// get file info, and check whether support
		//
		$file_info = new finfo(FILEINFO_MIME_TYPE);
		$mime = $file_info->file($upload_file['tmp_name']);

		$file_extensions = array(
			'image' => array(
				'image/jpeg' => 'jpg',
				'image/png' => 'png'
			),
			'audio' => array(
				'audio/mpeg' => 'mp3'
			)
		);

		if ( !isset($file_extensions[$type]) || !isset($file_extensions[$type][$mime]) ) {
			echo $mime;
			exit('Un-support file format');
		}

		// check if destination file exists
		//
		$source .= '.' . $file_extensions[$type][$mime];
		if ( file_exists($source) ) {
			exit('Target file already exist, please upload later');
		}

		$resource_path = 'resources/' . $type . '/';
		$target_file = $resource_path . $source;

		// move file to resource path to store
		//
		if ( ! move_uploaded_file($upload_file['tmp_name'], $target_file) ) {
			exit('Fail when moving the file from tmp dir');
		}

//		$data = array(
//			'name' => $name,
//			'type' => $type,
//			'md5' => $md5,
//			'source' => $source
//		);
//
//		$sql = "INSERT INTO resource (id, name, type, source, md5) " .
//			"VALUES (NULL, '{$data['name']}', '{$data['type']}', '{$data['source']}', '{$data['md5']}')";

		$data = array(
			$name, $type, $source, $md5
		);

		$sql = 'INSERT INTO resource (name, type, source, md5) VALUES (?, ?, ?, ?)';
		$query = $db->prepare($sql);

		if ( $query->execute($data) ) {
			$query = $db->query('SELECT last_insert_rowid() AS num');
			$result = $query->fetch(PDO::FETCH_ASSOC);
			$row_id = $result['num'];

			echo('Last Insert ID is: ' . $row_id);
		}
		else {
			echo $sql, PHP_EOL;
			echo $target_file, PHP_EOL;
			unlink($target_file);
			exit('Fail when insert a record');
		}

	}
	else {
		print_r($_FILES);
		print_r($_POST);
		exit('invalid upload file<br>');
	}
else: ?>
<html>
<head>
	<title>Resource Tools</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css"
</head>
<body>
<div class="container">
	<form class="form-horizontal" action="#" enctype="multipart/form-data" method="post">
		<h3>Please select a file to upload:</h3>
		<div class="form-group">
			<label class="col-md-2 control-label">Resource Name:</label>
			<div class="col-md-4">
				<input class="form-control input-sm" name="name" type="text">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Resource Type:</label>
			<div class="col-md-4">
				<select class="form-control" name="type">
					<option value="image" selected="selected">Image</option>
					<option value="audio">Audio</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Upload File:</label>
			<div class="col-md-4">
				<input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
				<input name="file" type="file" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-2 col-md-offset-2">
				<button type="submit" class="btn btn-sm btn-info">Submit</button>
			</div>
		</div>
	</form>
	<p><a href="manage.php">Back to manage page</a></p>
	<script language="JavaScript" src="assets/js/jquery-1.11.0.min.js"></script>
	<script language="JavaScript" src="assets/js/bootstrap.min.js"></script>
</div>
</body>
</html>
<?php endif; ?>
