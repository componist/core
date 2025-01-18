# Multi Selected


- $liste => must have array
- selected => is livewire Variable

- array filter by id array_column($selectedListe, 'filterById')
```php

<x:component::element.multi-selected :liste="$liste" selected="selected" />

```