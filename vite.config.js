import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import AutoImport from 'unplugin-auto-import/dist/vite.js'

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
        AutoImport({
            imports: ['vue']
        }),
        laravel({
            input: ['resources/js/app.js'],
            refresh: true
        })
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '@css': '/resources/css',
            '@img': '/resources/images',
        }
    }
})

/*
{
  template: {
    transformAssetUrls: {
      base: null,
        includeAbsolute: false
    }
  }
}
*/
