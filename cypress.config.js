const { defineConfig } = require("cypress");

module.exports = defineConfig({
  projectId: 'r52tne',
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});
