<?php
/**
 * Created by PhpStorm.
 * User: mains2114
 * Date: 14-12-28
 * Time: 下午10:19
 */

require_once 'include.php';
require_once 'database.php';
require_once 'session.php';

$params = array(
	'limit' => (int) Input::get('limit') ? (int) Input::get('limit') : 10,
	'offset' => (int) Input::get('offset') ? (int) Input::get('offset') : 0
);
//var_dump($params);

// get num of records in database
// check whether it's empty
//
$query = $db->query('SELECT COUNT(*) AS num FROM resource');
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);
//var_dump($result);

$data['num'] = (int) $result;

$query = $db->query('SELECT * FROM resource LIMIT '.$params['offset'].','.$params['limit']);
$records = $query->fetchAll(PDO::FETCH_ASSOC);
//var_dump($records);
?>
<html>
<head>
	<title>Resource Tools</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css"
</head>
<body>
  <div class="container">
	  <h3>Resource Tools</h3>
	  <p>
		  <a href="upload.php">Upload Resource</a>
		  <a href="logout.php" class="pull-right">Logout</a>
	  </p>
	  <table class="table table-bordered">
		  <thead>
			  <tr>
				  <th class="text-center">ID</th>
				  <th class="text-center">Name</th>
				  <th class="text-center">Type</th>
				  <th class="text-center">Source</th>
				  <th class="text-center">MD5</th>
				  <th class="text-center">Copy</th>
				  <th class="text-center">Edit</th>
				  <th class="text-center">Delete</th>
			  </tr>
		  </thead>
		  <tbody>
		  <?php if ( !empty($records) ): ?>
		  <?php foreach ($records as $i): ?>
		  	<tr class="text-center">
				<td><?=$i['id']?></td>
				<td><?=$i['name']?></td>
				<td><span class="text-capitalize"><?=$i['type']?></span></td>
				<td><a target="_blank" href="resources/<?=$i['type'].'/'.$i['source']?>"><?=$i['source']?></a></td>
				<td><?=$i['md5']?></td>
				<td><a href="#"><span class="glyphicon glyphicon-share"></span></a></td>
				<td><a href="edit.php?rid=<?=$i['id']?>"><span class="glyphicon glyphicon-edit"></span></a></td>
				<td><a href="delete.php?rid=<?=$i['id']?>"><span class="glyphicon glyphicon-remove"></span></a></td>
		  	</tr>
		  <?php endforeach; ?>
		  <?php else: ?>
			<tr>
				<td colspan="5">Empty Records~</td>
			</tr>
		  <?php endif; ?>
		  </tbody>
	  </table>
  </div>
<script language="JavaScript" src="assets/js/jquery-1.11.0.min.js"></script>
<script language="JavaScript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
