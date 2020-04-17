<?php



include ('src/PictureExifReader.php');

$pics = new PictureExifReader();
$pics->setPicturesDirectory('images/');
$data = $pics->getPicturesAndFilesData();
var_dump($data);
