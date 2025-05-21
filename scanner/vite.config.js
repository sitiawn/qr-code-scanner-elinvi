import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0", // biar bisa diakses dari luar
        port: 5173, // default port Vite
        strictPort: true, // jangan ganti port
        // hmr: {
        //     host: "53fc-114-10-145-103.ngrok-free.app",
        //     protocol: "wss", // pakai wss karena https
        // },
        hmr: {
            host: "192.168.43.79", // ← wajib pakai IP LAN/hotspot, bukan localhost
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        rollupOptions: {
            input: ["resources/css/app.css", "resources/js/app.js"],
        },
    },
    base: process.env.ASSET_URL ? process.env.ASSET_URL + "/build/" : "/build/",
});
