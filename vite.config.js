import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/main.css",
                "resources/css/admin.css",
                "resources/js/app.js",
                "resources/js/validation.js",
                "resources/js/map-init.js",
                "resources/js/notifications.js",
            ],
            refresh: true,
        }),
    ],
});
