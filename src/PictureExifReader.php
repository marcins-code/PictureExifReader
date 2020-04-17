<?php


namespace App;


class PictureExifReader
{
    /**
     * @var string
     */
    private $picturesDir;






    /**
     * @param string $picturesDir
     */
    public function setPicturesDir($picturesDir)
    {
        $this->picturesDir = $picturesDir;
    }
}
