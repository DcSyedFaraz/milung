import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
// import alias from '@rollup/plugin-alias';

export default defineConfig({
    // server: {
    //     host: 'http://ordersystem.creatricx.com/',  // Add this to force IPv4 only
    // },
  plugins: [
    // alias({
    //     $: 'jquery',
    //   }),
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
      })
  ],
});
