<?php

namespace App\Http\Services;

use App\Enums\MediaType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

class MediaReader
{
    public UploadedFile $file;

    public FFmpegReader $videoReader;

    public string $uuid;

    public function setFile(UploadedFile $file): void
    {
        $this->uuid = Str::uuid();
        $this->file = $file;
        $this->videoReader = new FFmpegReader();
        $this->videoReader->setPath($this->getPathName());
    }

    public function getImageInterface(): ImageInterface
    {
        return ImageManager::imagick()->read($this->file->getPathname());
    }

    public function getName(): string
    {
        return $this->uuid.'.'.$this->getFormat();
    }

    public function getPathName(): string
    {
        return $this->file->getPathname();
    }

    public function getFormat(): string
    {
        return pathinfo($this->file->hashName(), PATHINFO_EXTENSION);
    }

    public function isVideo(): bool
    {
        if (in_array($this->getFormat(), MediaType::VIDEO)) {
            return true;
        }

        return false;
    }

    public function getWidth(): int
    {
        if (! $this->isVideo()) {
            return $this->getImageInterface()->width();
        }

        return $this->videoReader->getWidth();
    }

    public function getHeight(): int
    {
        if (! $this->isVideo()) {
            return $this->getImageInterface()->height();
        }

        return $this->videoReader->getHeight();
    }
}
