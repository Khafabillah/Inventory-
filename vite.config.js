import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        // Konfigurasi ini memungkinkan Vite diakses dari perangkat lain (HP)
        // melalui IP Lokal laptop Anda.
        host: "0.0.0.0",
    },
});
