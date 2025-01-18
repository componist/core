import './bootstrap';

//https://github.com/livewire/sortable
import 'livewire-sortable';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus'

window.Alpine = Alpine;

Alpine.plugin(focus)
Alpine.start();


import './copy';