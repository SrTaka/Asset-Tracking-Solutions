<?php
try {
    if (!class_exists('Imagick')) {
        fwrite(STDERR, "Imagick extension is not installed or not enabled.\n");
        exit(2);
    }
    $image = new Imagick();
    $image->newImage(1, 1, new ImagickPixel('#ffffff'));
    $image->setImageFormat('png');
    $pngData = $image->getImagesBlob();
    echo strpos($pngData, "\x89PNG\r\n\x1a\n") === 0 ? 'Ok' : 'Failed';
    echo "\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'Error: ' . $e->getMessage() . "\n");
    exit(1);
}


