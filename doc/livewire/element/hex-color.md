# Color Piker

## Include in your Template
```php
@livewire('element.hex-colors', [
    'selectedColor' => $value['bgColor'],
    'rowId' => $value['id'], // optional
    'event' => 'setBackgroundColorById', // optional default lis => hexColor
],key(uniqid())
```



## in Livewire Controller
```php
protected $listeners = [
    'hexColor' => 'Your_Methode_hier',
];
```