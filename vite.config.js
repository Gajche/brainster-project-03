import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite"; //

export default defineConfig({
    plugins: [
        tailwindcss(), // Add this BEFORE the laravel plugin
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/main.css",
                "resources/css/admin.css",
                "resources/js/app.js",
                "resources/js/validation.js",
            ],
            refresh: true,
        }),
    ],
});
