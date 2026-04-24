import "./bootstrap";

import "./navbar";

import "./validation";

import "./slider";

import Alpine from "alpinejs";

import $ from "jquery";

import toastr from "toastr";

import { initNotifications } from "./notifications";

// Make sure it runs after the DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    initNotifications();
});

// global
window.$ = window.jQuery = $;
window.toastr = toastr;

window.Alpine = Alpine;

Alpine.start();
