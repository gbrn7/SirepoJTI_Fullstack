import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    baseUrl: "http://localhost:8000",
    viewportHeight: 720,
    viewportWidth: 1024,
    video: false,
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});
