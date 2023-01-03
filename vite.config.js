import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
//import pinia from 'vue-cli-plugin-pinia'

import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        //pinia(),
        vue(),
        laravel({
            input: [
                //'resources/css/app.css', 
                //'resources/js/app.js'
                'resources/js/main.js', 
            ],
            refresh: true,
        }),
    ],
    build: {
        watch: true,
    }
});
