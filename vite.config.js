import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import { PrimeVueResolver } from 'unplugin-vue-components/resolvers';
import { createStyleImportPlugin } from 'vite-plugin-style-import';
// import alias from '@rollup/plugin-alias';

export default defineConfig({
    // server: {
    //     host: 'http://ordersystem.creatricx.com/',  // Add this to force IPv4 only
    // },
    plugins: [
        createStyleImportPlugin({
            libs: [
                {
                    libraryName: 'primevue',
                    esModule: true,
                    resolveStyle: (name) => {
                        return `primevue/resources/themes/saga-blue/theme.css`;
                    },
                },

            ],
        }),

        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['Datatable'].includes(tag),
                }
            }
        }),
        AutoImport({
            resolvers: [PrimeVueResolver()],
        }),
        Components({
            resolvers: [
                PrimeVueResolver()
            ]
        })
    ],
});
