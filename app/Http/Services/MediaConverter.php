<?php

namespace App\Http\Services;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;

class MediaConverter
{
    public static array $mp4Params = [
        '-profile:v',
        'baseline',
        '-pix_fmt',
        'yuv420p',
        '-vf',
        'scale=trunc(iw/2)*2:trunc(ih/2)*2',
    ];

    public static array $ffmpegConfiguration = [
        'ffmpeg.binaries' => '/usr/bin/ffmpeg',
        'ffprobe.binaries' => '/usr/bin/ffprobe',
        'timeout' => 6600, // The timeout for the underlying process
        'ffmpeg.threads' => 1,   // The number of threads that FFMpeg should use
    ];

    public static array $mp4Codecs = [
        'libvo_aacenc',
        'libx264',
    ];

    public static function fromGifToMp4(string $path): void
    {
        $ffmpeg = FFMpeg::create(static::$ffmpegConfiguration);

        $video = $ffmpeg->open($path);

        $format = new X264(...static::$mp4Codecs);
        $format->setAdditionalParameters(static::$mp4Params);

        $video->save($format, str_replace('.gif', '.mp4', $path));
    }
}
