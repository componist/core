<?php

namespace Componist\Core\Controllers;

use App\Http\Controllers\Controller;
use Componist\Core\Models\MenuItem;

class PageController extends Controller
{
    public function index(string $pageslug)
    {
        // $page = MenuItem::where('url', $pageslug)->first()->toArray();
        // dump($page);

        // dd($pageslug);

        $content = (object) [
            'title' => 'Seiten Title',
            'description' => 'Seiten Beschreibung',
            'keywords' => 'Seiten keywords',
        ];

        if (file_exists(resource_path('/views/page/'.$pageslug.'.blade.php'))) {
            return view('page.'.$pageslug, compact('content'));
        } else {
            // dd('wurde nicht gefunden');
            return null;
        }

    }
}
