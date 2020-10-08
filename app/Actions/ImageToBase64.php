<?php


namespace App\Actions;


use Illuminate\Support\Facades\Cache;

class ImageToBase64
{
    public function execute($image): string
    {
        if (Cache::has($image)) {
            return Cache::get($image);
        }
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        Cache::put($image, $base64, now()->addYear());

        return $base64;
    }
}
