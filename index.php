<?php
/* CONFIGURATOR */
$avito = $_GET['url'];

/* MAIN CODE */
$page = file_get_contents($avito);
$goodarr = array();
preg_match_all( '#data-url="//(.+?)"#is', $page, $imgs ); 
for($i=0;$i<count($imgs[1]);$i++)
{
    if (strpos($imgs[1][$i], '1280x960') !== false) array_push($goodarr, $imgs[1][$i]);
}


// Очистка предыдущих файлов
cleanDir('avt');
function cleanDir($dir) {
    $files = glob($dir."/*");
    $c = count($files);
    if (count($files) > 0) {
        foreach ($files as $file) {      
            if (file_exists($file)) {
            unlink($file);
            }   
        }
    }
}

for($i=0;$o<count($goodarr);$i++)
{
    av_graber("https://".$goodarr[$i]);
}

echo 'good job';

// Функция убирания копирайтов с авито
function av_graber($img)
{
    $imgSrc = $img;
    //getting the image dimensions
    list($width, $height) = getimagesize($imgSrc);
    //saving the image into memory (for manipulation with GD Library)
    $myImage = imagecreatefromjpeg($imgSrc);
    // calculating the part of the image to use for thumbnail
    if ($width > $height) {
      $y = 0;
      $x = ($width - $height) / 2;
      $smallestSide = $height;
    } else {
      $x = 0;
      $y = ($height - $width) / 2;
      $smallestSide = $width;
    }
    // copying the part into thumbnail
    $thumbSize = $width;
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

    imagejpeg($thumb, 'avt/'.rand(1,5543543).'.jpg');
    imagedestroy($thumb);
}
?>
