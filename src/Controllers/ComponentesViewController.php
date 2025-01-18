<?php

namespace Componist\Core\Controllers;

use App\Http\Controllers\Controller;

class ComponentesViewController extends Controller
{
    public $listeOfElements = [];

    public $resources_path = './../resources/views/components';

    private $package_path = __DIR__.'../../../resources/views/components';

    public function index()
    {
        $content = $this->listDir($this->package_path);

        return view('component::components-liste', compact('content'));
    }

    public function resources()
    {
        $content = $this->listDir($this->resources_path);

        return view('component::components-liste', compact('content'));
    }

    private function listDir($path)
    {
        $liste = [];

        if (file_exists($path)) {
            foreach (scandir($path) as $element) {
                if ($element !== '..' && $element !== '.') {
                    $temp = [];
                    if (is_dir($path.'/'.$element)) {
                        $temp['name'] = $element;
                        $temp['date'] = $this->listDir($path.'/'.$element);
                    } else {
                        $temp = str_replace('.blade.php', '', $element);
                    }
                    $liste[] = $temp;
                }
            }

            return $liste;
        }

        return false;
    }
}
