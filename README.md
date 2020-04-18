# PictureExifReader
Even pictures taken by mobile phones contains metadata. There are applications to add/edit exif data for pictures. The best are paid like Adobe Aperture, but free software like AnalogExif can manage exif data as well.
Proper preparation of exif data may avoid a lot of work during creation photos gallery.
Class `PictureExifReader` gets all pictures from directory and returns array with most useful data for each pictures.

### Demo
Download this repository and run index.php to see very basic demo. All pictures are mine are under free licence.

## Usage

```php
include('src/PictureExifReader.php');

$galleryPath = 'demo/images/gallery/'; //path to folder with pictures
$pics = new PictureExifReader();
$pics->setPicturesDirectory($galleryPath);
```
#### retrieve pictures data
```php
$images = $pics->getPicturesData();
```
*example result:*
```php
array (size=10)
      'FileName' => string 'nigth_warsaw.jpg' (length=16)
      'ApertureFNumber' => string 'f/5.0' (length=5)
      'Copyright' => string 'Copyright-Free' (length=14)
      'ImageDescription' => string 'My neighborhood by night' (length=24)
      'Model' => string 'Canon EOS 550D' (length=14)
      'Artist' => string 'Marcin Paczkowski' (length=17)
      'ExposureTime' => string '60/1' (length=4)
      'ISOSpeedRatings' => int 400
      'DateTimeOriginal' => string '2019:05:20 22:48:30' (length=19)
      'FocalLength' => string '39/1' (length=4)
```
---
#### retrieve pictures data
```php
$images = $pics->getFilesData();
```
*example result:*
```php
array (size=5)
      'FileName' => string 'nigth_warsaw.jpg' (length=16)
      'FileSize' => int 681782
      'MimeType' => string 'image/jpeg' (length=10)
      'Height' => int 853
      'Width' => int 1280
```
---
#### retrieve all data
```php
$images = $pics->getPicturesAndFilesData();
```
Joined 2 first results

*example result:*
```php
   array (size=14)
      'FileName' => string 'nigth_warsaw.jpg' (length=16)
      'FileSize' => int 681782
      'MimeType' => string 'image/jpeg' (length=10)
      'Height' => int 853
      'Width' => int 1280
      'ApertureFNumber' => string 'f/5.0' (length=5)
      'Copyright' => string 'Copyright-Free' (length=14)
      'ImageDescription' => string 'My neighborhood by night' (length=24)
      'Model' => string 'Canon EOS 550D' (length=14)
      'Artist' => string 'Marcin Paczkowski' (length=17)
      'ExposureTime' => string '60/1' (length=4)
      'ISOSpeedRatings' => int 400
      'DateTimeOriginal' => string '2019:05:20 22:48:30' (length=19)
      'FocalLength' => string '39/1' (length=4)
```
>>>>>>> 52cbe715a690881af015b0ae5c7bd28cd984e4ec
