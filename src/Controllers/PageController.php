<?php

namespace Componist\Core\Controllers;

use App\Http\Controllers\Controller;
use Componist\Core\Models\MenuItem;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function index(string $pageslug): ?View
    {
        // $page = MenuItem::where('url', $pageslug)->first()->toArray();
        // dump($page);

        // dd($pageslug);

        $content = (object) [
            'title' => 'Seiten Title',
            'description' => 'Seiten Beschreibung',
            'keywords' => 'Seiten keywords',
        ];

        $view = 'page.'.$pageslug;

        if (view()->exists($view)) {
            return view($view, compact('content'));
        } else {
            // dd('wurde nicht gefunden');
            return null;
        }

    }
}
