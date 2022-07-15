<?php
namespace App\Lib;

use Exception;
use Intervention\Image\Exception\ImageException;

class Thumbnail
{

    public const SMALL_THUMB_WIDTH   = 280;
    public const SMALL_THUMB_HEIGHT  = 200;
    public const MEDIUM_THUMB_WIDTH  = 500;
    public const MEDIUM_THUMB_HEIGHT = 220;
    public const LARGE_THUMB_WIDTH   = 720;
    public const LARGE_THUMB_HEIGHT  = 440;

    /**
     * @param string $image
     * @param string|null $saveTo
     *
     * @return mixed
     */
    public static function createSmall(string $image, ?string $saveTo = null): mixed
    {
        return self::makeThumbnail($image, self::SMALL_THUMB_WIDTH, self::SMALL_THUMB_HEIGHT, $saveTo);
    }

    /**
     * @param string $image
     * @param string|null $saveTo
     *
     * @return mixed
     */
    public static function createMedium(string $image, ?string $saveTo = null): mixed
    {
        return self::makeThumbnail($image, self::MEDIUM_THUMB_WIDTH, self::MEDIUM_THUMB_HEIGHT, $saveTo);
    }

    /**
     * @param string $image
     * @param string|null $saveTo
     *
     * @return mixed
     */
    public static function createLarge(string $image, ?string $saveTo = null): mixed
    {
        return self::makeThumbnail($image, self::LARGE_THUMB_WIDTH, self::LARGE_THUMB_HEIGHT, $saveTo);
    }

    /**
     * @param string $originalImagePath
     * @param int $width
     * @param int $height
     * @param string|null $saveTo
     *
     * @return mixed
     */
    private static function makeThumbnail(string $originalImagePath, int $width, int $height, ?string $saveTo = null): mixed
    {

        try {
            if (!file_exists($originalImagePath)) {
                return false;
            }

            $img = \Intervention\Image\Facades\Image::make($originalImagePath)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($saveTo) {
                @mkdir($saveTo, 0777, true);
            }

            $fileInfo = pathinfo($originalImagePath);
            $fileName = $fileInfo['filename'] . "_" . (string) $width . "x" . (string) $height . "." . $fileInfo['extension'];
            $path     = ($saveTo ?? $fileInfo['dirname']) . "/" . $fileName;

            $img->save($path);

            return preg_replace("/.*assets\//", "", $path);
        } catch (ImageException $e) {
            throw new Exception($e);
        }
    }
}
