// vite.config.js
import { defineConfig } from "file:///D:/Faraz/1Raheel/Milung/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/Faraz/1Raheel/Milung/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///D:/Faraz/1Raheel/Milung/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Components from "file:///D:/Faraz/1Raheel/Milung/node_modules/unplugin-vue-components/dist/vite.js";
import { PrimeVueResolver } from "file:///D:/Faraz/1Raheel/Milung/node_modules/unplugin-vue-components/dist/resolvers.js";
var vite_config_default = defineConfig({
  // server: {
  //     host: 'http://ordersystem.creatricx.com/',  // Add this to force IPv4 only
  // },
  plugins: [
    // alias({
    //     $: 'jquery',
    //   }),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => ["Datatable"].includes(tag)
        }
      }
    }),
    Components({
      resolvers: [
        PrimeVueResolver()
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxGYXJhelxcXFwxUmFoZWVsXFxcXE1pbHVuZ1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiRDpcXFxcRmFyYXpcXFxcMVJhaGVlbFxcXFxNaWx1bmdcXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0Q6L0ZhcmF6LzFSYWhlZWwvTWlsdW5nL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJztcbmltcG9ydCBDb21wb25lbnRzIGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGUnO1xuaW1wb3J0IHtQcmltZVZ1ZVJlc29sdmVyfSBmcm9tICd1bnBsdWdpbi12dWUtY29tcG9uZW50cy9yZXNvbHZlcnMnO1xuLy8gaW1wb3J0IGFsaWFzIGZyb20gJ0Byb2xsdXAvcGx1Z2luLWFsaWFzJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICAvLyBzZXJ2ZXI6IHtcbiAgICAvLyAgICAgaG9zdDogJ2h0dHA6Ly9vcmRlcnN5c3RlbS5jcmVhdHJpY3guY29tLycsICAvLyBBZGQgdGhpcyB0byBmb3JjZSBJUHY0IG9ubHlcbiAgICAvLyB9LFxuICBwbHVnaW5zOiBbXG4gICAgLy8gYWxpYXMoe1xuICAgIC8vICAgICAkOiAnanF1ZXJ5JyxcbiAgICAvLyAgIH0pLFxuICAgIGxhcmF2ZWwoe1xuICAgICAgaW5wdXQ6IFsncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJywgJ3Jlc291cmNlcy9qcy9hcHAuanMnXSxcbiAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgfSksXG4gICAgdnVlKHtcbiAgICAgICAgdGVtcGxhdGU6IHtcbiAgICAgICAgICBjb21waWxlck9wdGlvbnM6IHtcbiAgICAgICAgICAgIGlzQ3VzdG9tRWxlbWVudDogKHRhZykgPT4gWydEYXRhdGFibGUnXS5pbmNsdWRlcyh0YWcpLFxuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSksXG4gICAgICBDb21wb25lbnRzKHtcbiAgICAgICAgcmVzb2x2ZXJzOiBbXG4gICAgICAgICAgUHJpbWVWdWVSZXNvbHZlcigpXG4gICAgICAgIF1cbiAgICAgIH0pXG4gIF0sXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBK1AsU0FBUyxvQkFBb0I7QUFDNVIsT0FBTyxhQUFhO0FBQ3BCLE9BQU8sU0FBUztBQUNoQixPQUFPLGdCQUFnQjtBQUN2QixTQUFRLHdCQUF1QjtBQUcvQixJQUFPLHNCQUFRLGFBQWE7QUFBQTtBQUFBO0FBQUE7QUFBQSxFQUkxQixTQUFTO0FBQUE7QUFBQTtBQUFBO0FBQUEsSUFJUCxRQUFRO0FBQUEsTUFDTixPQUFPLENBQUMseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3RELFNBQVM7QUFBQSxJQUNYLENBQUM7QUFBQSxJQUNELElBQUk7QUFBQSxNQUNBLFVBQVU7QUFBQSxRQUNSLGlCQUFpQjtBQUFBLFVBQ2YsaUJBQWlCLENBQUMsUUFBUSxDQUFDLFdBQVcsRUFBRSxTQUFTLEdBQUc7QUFBQSxRQUN0RDtBQUFBLE1BQ0Y7QUFBQSxJQUNGLENBQUM7QUFBQSxJQUNELFdBQVc7QUFBQSxNQUNULFdBQVc7QUFBQSxRQUNULGlCQUFpQjtBQUFBLE1BQ25CO0FBQUEsSUFDRixDQUFDO0FBQUEsRUFDTDtBQUNGLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
