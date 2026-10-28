<?php

namespace Componist\Core\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $menu_id
 * @property string $title
 * @property string|null $icon
 * @property string $type
 * @property string $target
 * @property int|null $parent_id
 * @property int|null $page_id
 * @property int|null $order
 * @property string|null $name
 * @property string|null $slug
 * @property int $status
 * @property string|null $view_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class MenuItem extends Model
{
    /** @use HasFactory<Factory<static>> */
    use HasFactory;

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->with('children');
    }

    public function parent_title(): ?string
    {
        return $this->hasOne(MenuItem::class, 'id', 'parent_id')->value('title');
    }

    /**
     * @return HasOne<Page, $this>
     */
    public function page(): HasOne
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
            $stub = file_get_contents(dirname(__DIR__, 2).'/stubs/settings/pages.stub');

            if ($stub === false) {
                return false;
            }

            $content = str_replace('[array]', $liste, $stub);

            if (file_put_contents(config_path('pages.php'), $content)) {
                return true;
            }
        }

        return false;
    }

    public static function createStubPage(string $slug): bool
    {
        if (! preg_match('/^[a-zA-Z0-9_.-]+$/', $slug) || str_contains($slug, '..')) {
            return false;
        }

        $explode = explode('.', trim($slug));

        $countExplodes = count($explode) - 1;

        $view_path = resource_path('views');

        foreach ($explode as $key => $path) {

            $view_path .= '/'.$path;

            if ($countExplodes == $key) {
                // file
                $file = $view_path.'.blade.php';

                if (! file_exists($file)) {
                    $stub = file_get_contents(dirname(__DIR__, 2).'/stubs/view/page.stub');

                    return $stub !== false && file_put_contents($file, $stub) !== false;
                }
            } else {
                // folder
                if (! is_dir($view_path)) {
                    mkdir($view_path, 0755, true);
                }
            }
        }

        return false;
    }
}
