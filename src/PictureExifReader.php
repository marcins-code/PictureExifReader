<?php


namespace App;

use DirectoryIterator;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class PictureExifReader
{
    /**
     * @var string
     */
    private $picturesDirectory;

    /**
     * @var array
     */
    private $acceptedTypes = ['jpg', 'jpeg', 'tiff'];

    /**
     * @var array
     */
    private $pictureData = ['FileName', 'Copyright', 'ApertureFNumber', 'ImageDescription', 'Model', 'Artist', 'ExposureTime', 'ISOSpeedRatings', 'DateTimeOriginal', 'FocalLength'];

    /**
     * @var array
     */
    private $fileData = ['FileName', 'FileSize', 'MimeType', 'Height', 'Width'];

    /**
     * @var array
     */
    private $flatExifOutput;

    /**
     * @var array
     */
    private $chosenDataArray;


    /**
     * @param string $pictureDirectory
     */
    public function setPicturesDirectory($pictureDirectory): void
    {
        $this->picturesDirectory = $pictureDirectory;
    }


    /**
     * Metoda pobiera wszystkie pliki z katalogu i usuwa pliki o rozrzerzeniach nieobługiwanych przez "exif_read_data"
     * @return array
     */
    private function getAcceptedFiles(): array
    {
        $fileList = new DirectoryIterator($this->picturesDirectory);

        foreach ($fileList as $file) {
            $acceptedFiles[] = $file->getBasename();
        }

        return preg_grep('/\.' . implode($this->acceptedTypes, '|') . '$/', $acceptedFiles);
    }


    /**
     * Metoda zwraca spłaszczoną tablicę ze wszytkimi danymi exif
     * @return array
     */
    private function getFullFlattenExif(): array
    {
        foreach ($this->getAcceptedFiles() as $file) {
            $fileExif[] = exif_read_data($this->picturesDirectory . '/' . $file);
        }

        foreach ($fileExif as $key => $items) {
            foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($items)) as $k => $v) {
                $flatArray[$k] = $v;
            }
            $this->flatExifOutput[$key] = $flatArray;
        }
        return $this->flatExifOutput;
    }

    /**
     * Metoda usuwa wszystkie elementy, których klucze nie pasują do tablicy $allowed
     * @param array $array
     * @return array
     */
    private function keepOnlyChosenElements(array $allowed): array
    {
        foreach ($this->getFullFlattenExif() as $key => $value) {
            $this->chosenDataArray[] = (array_intersect_key($value, array_flip($allowed)));
        }
        return $this->chosenDataArray;
    }

    /**
     * Metoda zwraca elementy, które są zawarte w  tablicy  $pictureData
     * @return array
     */
    public function getPicturesData(): array
    {

        return $this->keepOnlyChosenElements($this->pictureData);
    }

    /**
     * Metoda zwraca elementy, które są zawarte w  tablicy  $fileData
     * @return array
     */
    public function getFilesData(): array
    {

        return $this->keepOnlyChosenElements($this->fileData);
    }

    /**
     * Metoda zwraca elementy, które są elementami obu tablic  $fileData i $pictureData
     * @return array
     */
    public function getPicturesAndFilesData(): array
    {
        $fullData = (array_merge($this->pictureData, $this->fileData));
        return $this->keepOnlyChosenElements($fullData);

    }

}