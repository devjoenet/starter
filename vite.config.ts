import { wayfinder } from "@laravel/vite-plugin-wayfinder";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { run } from "vite-plugin-run";
import { defineConfig } from "vite";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/js/app.ts"],
      ssr: "resources/js/ssr.ts",
      refresh: true,
    }),
    tailwindcss(),
    wayfinder({
      formVariants: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    run([
      {
        name: "typescript transform",
        run: ["php", "artisan", "typescript:transform"],
        pattern: ["app/**/*Data.php"],
      },
    ]),
  ],
});
