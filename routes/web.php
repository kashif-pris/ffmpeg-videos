<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use FFMpeg;
use Symfony\Component\Process\Process;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;



Route::get('/', function () {
 
    $jsonFilePath = storage_path('app/file.json');
    $jsonContents = File::get($jsonFilePath);
    $data = json_decode($jsonContents, true);



    foreach ($data['elements'] as $element) {
        if ($element['type'] === 'video') {
            $inputFilePath = $element['src'];
        }
    }
    
   $width = ($data['layout']['width']);
   $height = ($data['layout']['height']);
   
    $outputFilePath = storage_path('app/videos/output.mp4');
    
    $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($inputFilePath);
    $video
    ->filters()
    ->resize(new FFMpeg\Coordinate\Dimension($width, $height))
    ->synchronize();




    $outputDirectory = storage_path('app/videos');
    if (!File::exists($outputDirectory)) {
        File::makeDirectory($outputDirectory, $mode = 0755, $recursive = true, $force = true);
    }
    
    $format = new FFMpeg\Format\Video\X264('aac', 'libx264');

    $format->setAdditionalParameters(['-preset', 'ultrafast']); 
    
    
    if ($video->save($format, $outputFilePath)) {
        return 'Video conversion completed!';
    } else {
        return 'Video conversion not completed';
    }
   
    
});


