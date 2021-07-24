require('./bootstrap');

import flatpickr from "flatpickr";
import language from 'flatpickr/dist/l10n/es';
flatpickr.localize(language.es);

import Alpine from 'alpinejs'
window.Alpine = Alpine
import reservation_step from './reservation_step.js'
Alpine.data('reservation_step', reservation_step)
Alpine.start()








