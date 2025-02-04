const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  transpileDependencies: true,
  publicPath: "/cos30043/s103837447/ootd",
  devServer: {
    port: process.env.PORT || 8080,
  },
});
