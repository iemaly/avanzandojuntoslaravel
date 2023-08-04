<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SiteController extends Controller
{
    public function generate()
    {
        $sitemap = Sitemap::create();

        // Add your website's routes to the sitemap
        $sitemap->add(Url::create('/')->setPriority(1.0));
        // Add more URLs as needed

        // Generate and return the sitemap XML
        return Response::make($sitemap->render(), 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
