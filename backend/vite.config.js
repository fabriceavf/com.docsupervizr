import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
const glob = require('glob')
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Vendor assets
 |--------------------------------------------------------------------------
 */

let AllAssets=['resources/sass/app.scss'];
function mixAssetsDir(query, cb) {
    ;(glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/')
        cb(f, f.replace('resources', 'public'))
    })
}

mixAssetsDir('views/content/*/main.js', (src, dest) =>
    AllAssets.push(src)
)
/*
 |--------------------------------------------------------------------------
 | Application assets
 |--------------------------------------------------------------------------
 */

// mixAssetsDir('css/**/*.css', (src, dest) => mix.copy(src, dest));

export default defineConfig({
    plugins: [
        laravel({
            input: AllAssets,
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/vuejs'),
            '@core': path.resolve(__dirname, 'resources/vuejs/@core'),
            '@validations': path.resolve(__dirname, 'resources/vuejs/@core/utils/validations/validations.js'),
            '@axios': path.resolve(__dirname, 'resources/vuejs/libs/axios'),
            '@themeConfig': path.resolve(__dirname, 'resources/vuejs/themeConfig.js'),
            vue: 'vue/dist/vue.esm.js',
        },
    },
});
