import { wayfinder } from "@laravel/vite-plugin-wayfinder";
import ui from "@nuxt/ui/vite";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import vueDevTools from "vite-plugin-vue-devtools";
import { compodium } from "@compodium/vue";
import path, { resolve } from "node:path";
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
    ui({
      inertia: true,
      components: {
        dirs: ["resources/js/components"],
      },
      ui: {
        colors: {
          primary: "scarlet",
          neutral: "neutral",
        },
      },
    }),
    vueDevTools(),
    compodium({
      /* Customize the directories where components are discovered */
      componentDirs: [{ path: "resources/js/components", pathPrefix: false }],

      /* Customize compodium's base directory. */
      dir: "compodium/",

      /**
       * Configure your application's mainPath
       */
      mainPath: "resources/js/app.ts",

      /* List of glob patterns to ignore components */
      ignore: [],

      /* Whether to include default collections for third-party libraries. */
      includeLibraryCollections: true,

      extras: {
        /*
         * Customize Compodium's UI Colors.
         * See: https://ui.nuxt.com/getting-started/theme#colors for acceptable values
         */
        colors: {
          primary: "green",
          neutral: "zinc",
        },
      },
    }),
  ],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./resources/js"),
      "#build/ui": path.resolve("./node_modules/@nuxt/ui/.nuxt/ui"),
    },
  },
});
