# Menu einstellungen und optionen

## Menu auswählen

```php
{{ menu('menu_name', 'template_name') }}

zb.
{{ menu('admin', 'admin') }}
```
Der Menüblock kann beliebig plaziert werden.

### Methode aufbau
- erstes 'admin' für den namen des menus in der datenbank
- zweite 'admin' für das template wie es dargestellt werden soll

## Template Optionen
Pfad zu der Datei **componist/core/resources/views/template/menu/**
- - - account = formated
- - - admin = formated
- - - default = formated
- - - horizontal = formated
- - - vertical = formated
- - - array = return json array 

weitere templates können beliebig erstellt werden.