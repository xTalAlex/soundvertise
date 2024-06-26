<?php

namespace App\MediaLibrary;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class CustomPathGenerator extends DefaultPathGenerator
{
    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');
        if ($prefix !== '') {
            $prefix .= '/';
        }

        $modelFolder = Str::of($media->model_type)->classBasename()->plural()->snake('-').'/'.$media->model_id.'/';

        return $prefix.$modelFolder.$media->getKey();
    }
}
