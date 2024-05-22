<?php

namespace App\Http\Services;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

class FFmpegReader
{
    public string $path;

    public function setPath($path)
    {
        $this->path = $path;
    }

    protected function getFFprobe()
    {

        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($this->path);

        $ffprobe = FFProbe::create();

        return $ffprobe;
    }

    protected function getDimensions()
    {
        return $this->getFFprobe()->streams($this->path)->videos()->first()->getDimensions();
    }

    public function getWidth()
    {
        return $this->getDimensions()->getWidth();
    }

    public function getHeight()
    {
        return $this->getDimensions()->getHeight();
    }
}
