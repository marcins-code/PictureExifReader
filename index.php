<?php


include('src/PictureExifReader.php');
$galleryPath = 'demo/images/gallery/';
$pics = new PictureExifReader();
$pics->setPicturesDirectory($galleryPath);
$images = $pics->getPicturesAndFilesData();
function showElement($icon, $title, $element)
{
    echo '<i class="' . $icon . '"></i> <strong>' . $title . '</strong>: ' . $element;
}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="demo/css/style.css">
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" data-auto-replace-svg="nest"></script>
    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <h1 class="mt-3">Exif reader class demo</h1>
    <hr/>

    <div id="carouselExampleCaptions" class="carousel slide mb-5" data-ride="carousel">
        <ol class="carousel-indicators">

            <?php foreach ($images as $key => $image) { ?>
                <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key; ?>"
                    class="<?php if ($key == 0) {
                        echo 'active';
                    } ?>"></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($images as $key => $image) {
                ?>
                <div class="carousel-item <?php if ($key == 0) {
                    echo 'active';
                } ?>">
                    <img src="<?php echo $galleryPath . $image['FileName']; ?> " class="d-block w-100 "
                         alt="<?php echo $image['ImageDescription']; ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $image['ImageDescription']; ?></h5>
                        <p>
                            <span class="mr-1"><?php showElement('far fa-sun', 'Aperture', $image['ApertureFNumber']); ?></span>
                            |
                            <span class="mr-1"><?php showElement('far fa-clock', 'Exposure', $image['ExposureTime']); ?>s</span>
                            |
                            <span class="mr-1"><?php showElement('fas fa-adjust', 'ISO', $image['ISOSpeedRatings']); ?></span>
                            |
                            <span class="mr-1"><?php showElement('fas fa-arrows-alt-h', 'Focal Length', (int)$image['FocalLength']); ?>mm</span>
                            |
                            <span class="mr-1"><?php showElement('fas fa-camera-retro', 'Camera', $image['Model']); ?></span>

                            <br/>
                            <span class="mr-1"><?php showElement('fas fa-user', 'Author', $image['Artist']); ?></span> |
                            <span class="mr-1"><?php showElement('fas fa-copyright', '', $image['Copyright']); ?></span>
                            |
                            <span class="mr-1"><?php showElement('fas fa-calendar-alt', 'Created', $image['DateTimeOriginal']); ?></span>
                            <br/>
                            <span class="mr-1"><?php showElement('far fa-file-image', 'File name', $image['FileName']); ?></span>|
                            <span class="mr-1"><?php showElement('far fa-hdd', 'File size', number_format($image['FileSize'] / 1000000, 2)); ?>MB</span>|
                            <span class="mr-1"><?php showElement('fas fa-arrows-alt-h', 'Picture width', $image['Width']); ?>px</span>|
                            <span class="mr-1"><?php showElement('fas fa-arrows-alt-v', 'Picture height', $image['Height']); ?>px</span>
                        </p>
                    </div>
                </div>

                <?php
            }
            ?>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <p>
        <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
            Show array dump
        </button>
    </p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <pre>
            <?php var_dump($images); ?>
            </pre>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>
