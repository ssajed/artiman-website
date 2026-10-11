/*
|--------------------------------------------------------------------------
| Website Module Scripts
|--------------------------------------------------------------------------
|
| Main JavaScript entry point for the public website.
| Uses Alpine.js for lightweight interactivity and Bootstrap Collapse component.
|
*/

// Bootstrap JS - Only required components
import 'bootstrap/js/dist/collapse';

// Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();