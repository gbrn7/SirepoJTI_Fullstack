import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    baseUrl: "https://sirepo-jti.raygbrn.site",
    viewportHeight: 720,
    viewportWidth: 1024,
    video: false,
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});
