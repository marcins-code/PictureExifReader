<?php


class PictureExifReader
{
    /**
     * @var string
     */
    private $picturesDir;

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
    private $flattenExif;

    /**
     * @var array
     */
    private $chosenData;


    /**
     * @param string $pictureDirectory
     */
    public function setPicturesDirectory($picturesDir): void
    {
        $this->picturesDir = $picturesDir;
    }


    /**
     * Metoda pobiera wszystkie pliki z katalogu i usuwa pliki o rozrzerzeniach nieobługiwanych przez "exif_read_data"
     * @return array
     */
    private function getOnlyAcceptedFiles(): array
    {
        $fileList = new \DirectoryIterator($this->picturesDir);

        foreach ($fileList as $file) {
            $acceptedFiles[] = $file->getBasename();
        }

        return preg_grep('/\.' . implode($this->acceptedTypes, '|') . '$/', $acceptedFiles);
    }


    /**
     * Metoda zwraca spłaszczoną tablicę ze wszytkimi danymi exif
     * @return array
     */
    private function getFlattenExif(): array
    {
        $fileExif = [];
        foreach ($this->getOnlyAcceptedFiles() as $file) {
            $fileExif[] = exif_read_data($this->picturesDir . '/' . $file);
        }

        foreach ($fileExif as $key => $items) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($items)) as $k => $v) {
                $flatArray[$k] = $v;
            }
            $this->flattenExif[$key] = $flatArray;
        }
        return $this->flattenExif;
    }

    /**
     * Metoda usuwa wszystkie elementy, których klucze nie pasują do tablicy $allowed
     * @param array $allowed
     * @return array
     */
    private function getChosenElements(array $allowed): array
    {
        foreach ($this->getFlattenExif() as $key => $value) {
            $this->chosenData[] = (array_intersect_key($value, array_flip($allowed)));
        }
        return $this->chosenData;
    }

    /**
     * Metoda zwraca elementy, które są zawarte w  tablicy  $pictureData
     * @return array
     */
    public function getPicturesData(): array
    {

        return $this->getChosenElements($this->pictureData);
    }

    /**
     * Metoda zwraca elementy, które są zawarte w  tablicy  $fileData
     * @return array
     */
    public function getFilesData(): array
    {

        return $this->getChosenElements($this->fileData);
    }

    /**
     * Metoda zwraca elementy, które są elementami obu tablic  $fileData i $pictureData
     * @return array
     */
    public function getPicturesAndFilesData(): array
    {
        $fullData = (array_merge($this->pictureData, $this->fileData));
        return $this->getChosenElements($fullData);

    }

}
