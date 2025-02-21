<?php

namespace Componist\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * @return HasMany<MenuItem>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->with('children');
    }

    public function parent_title()
    {
        return $this->hasOne(MenuItem::class, 'id', 'parent_id')->value('title');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }

    public static function createPageConfigFile(): bool
    {
        if ($pages = MenuItem::where('type', 'page')->where('status', 1)->get()->toArray()) {
            $liste = '';
            foreach ($pages as $page) {
                $liste .= "'".$page['slug']."'".' => '."'".$page['view_path']."',\r\n\t";
            }
            $stub = file_get_contents(__DIR__.'../../../stubs/settings/pages.stub');

            $content = str_replace('[array]', $liste, $stub);

            if (file_put_contents(config_path('pages.php'), $content)) {
                return true;
            }
        }

        return false;
    }

    public static function createStubPage(string $slug): bool
    {
        $explode = explode('.', trim($slug));

        $countExplodes = count($explode) - 1;

        $view_path = __DIR__.'../../../../../../resources/views';

        foreach ($explode as $key => $path) {

            $view_path .= '/'.$path;

            if ($countExplodes == $key) {
                // file
                $file = $view_path.'.blade.php';

                if (! file_exists($file)) {
                    $stub = file_get_contents(__DIR__.'../../../stubs/view/page.stub');
                    file_put_contents($file, $stub);

                    return true;
                }
            } else {
                // folder
                if (! is_dir($view_path)) {
                    mkdir($view_path);
                }
            }
        }

        return false;
    }
}
