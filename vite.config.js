import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        react({
            jsxRuntime: 'automatic',
            babel: {
                plugins: [
                    ['@babel/plugin-transform-react-jsx', { runtime: 'automatic' }]
                ]
            }
        }),
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
    },
})