import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  build: {
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (id.includes('node_modules')) {
            if (id.includes('sentry')) {
              return 'sentry'
            }

            if (id.includes('vue')) {
              return 'vue'
            }

            return 'vendor'
          }

          return null
        },
      },
    },
  },
  plugins: [
    laravel([
      'resources/js/app.js',
      'resources/css/app.css',
    ]),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
})
