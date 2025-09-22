
# Komponente

### Komponenten list aufrufen

```url
http://you-url/dashboard/componentes
```

### get all components from App/resources folder as list.

http:your-url/**dashboard/componente/resources/view**

### Componenten include

```php
# Input Label
 <x:component::form.label value="Package" />

# Controlle elements
<div class="flex gap-5">
    <x:component::button.show />

    <x:component::button.edit />

    <x:component::button.delete />

</div>

# Search Componente
<x:component::icon.search class="h-16" />
```

### Modal

```php
<x:component::element.modal>
    <x-slot:trigger>

        <x:component::button.delete @click.prevent="modal=true" />

    </x-slot:trigger>

    <x-slot:content>
        <div class="flex justify-center ">
            <div
                class="flex items-center justify-center text-red-500 bg-red-200 rounded-full shadow-sm w-28 h-28">
                <x:component::icon.delete class="h-16" />
            </div>
        </div>
        <div class="flex justify-center mt-7">
            <h3 class="text-lg font-bold text-center text-slate-700">unwiderruflich löschen?</h3>
        </div>
    </x-slot:content>

    <x-slot:controller>
        <button @click.prevent="modal=false" type="button"
            class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-slate-300 border border-transparent rounded-md shadow-sm hover:bg-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

        <button @click.prevent="modal=false" type="button"
            class="flex justify-center w-full px-4 py-2 font-medium text-center text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">löschen</button>
    </x-slot:controller>
</x:component::element.modal>
```

### Components Datepicker / Drop-File

```php
<x:component::datepicker model="date" />

<x-component::drop-file wire:model.live='temp_files' name="temp_files" title="jpg, png, pdf, docx (MAX. 10Mb)" />

```

---

## Livewire Komponente übersicht / einbinden

```php
# Markdown Editor include livewire componente
@livewire('markdown-x', ['content' => $content])

# controller livewire
protected $listeners = [
    'markdown-x:update' => 'updateBody',
];

# add Methode
public function updateBody($value)
{
    $this->content = $value;
}

------------------------------------

# select 2 include
@livewire('select2', [
    'table' => 'users',
    'event' => 'userId',
    'order' => 'name',
    'filter' => 'deleted_at,NULL',
    'selected' => $user_id,
    'add_function' => true,
])

# controller livewire
 protected $listeners = [
    'userId' => 'updateUserId',
];
# add methode
public function updateUserId(int $id = null)
{
    $this->user_id = $id;
}

```

## Layouts

```php
<x:component::layouts.guest>
    Dashboard Guest
</x:component::layouts.guest>


<x:component::layouts.app>
    Dashboard App
</x:component::layouts.app>


<x:component::layouts.dashboard>
    Dashboard Layout
</x:component::layouts.dashboard>
```

## Copy all packages components in your App (app/resources/views/components) (optional)

Dann kann die Komponente ganz normal aufgerufen werden.

```php
<x-form.label value="Package" />
```
