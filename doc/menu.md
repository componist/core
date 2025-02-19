# Menu einstellungen und optionen


## Erstellen eines Menü Blockes in der übersicht

## Menu auswählen und im code plazieren

Der Menüblock kann beliebig in der view plaziert werden.

```php
{{ menu('menu_name', 'template_name') }}

zb.
{{ menu('admin', 'admin') }}
```

#### Methode aufbau
- erstes 'admin' für den namen des menus in der datenbank
- zweite 'admin' für das template wie es dargestellt werden soll

#### Template Optionen
Pfad zu der Datei **componist/core/resources/views/template/menu/**
- - - account = formated
- - - admin = formated
- - - default = formated
- - - horizontal = formated
- - - vertical = formated
- - - array = return json array 

weitere templates können beliebig erstellt werden.


## Menü Item Optionen
- route (app routen)
- url (url kann verwendet werden auf eine externe webseite zu verlinken)
- page (app views)



## verwendung von Menü Item - Page
Wenn page nicht existiert wird sie erstellt in Ihrem resources/views/page verzeichniss.


### Automatisch erstellen von view Routen

Fügen Sie diese script in Ihre web.php datei.

```php

if(config()->has('pages')){
    foreach(config('pages') as $url => $viewPath){
        Route::view($url, $viewPath)->name($viewPath);
    } 
}
```