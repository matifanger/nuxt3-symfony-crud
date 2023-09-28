// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },

  modules: ["@nuxtjs/tailwindcss", "nuxt-headlessui"],

  runtimeConfig: {
    public: {
      BACKEND_URL: process.env.BACKEND_URL,
    },
  },

  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  build: {
    transpile: ["@headlessui/vue"],
  },

  css: ["@/assets/css/tailwind.css"],
});
