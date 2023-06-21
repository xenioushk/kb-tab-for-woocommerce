/**
 * External Dependencies
 */
const path = require("path")

/**
 * WordPress Dependencies
 */
const defaultConfig = require("@wordpress/scripts/config/webpack.config.js")
const MiniCssExtractPlugin = require("mini-css-extract-plugin")

module.exports = {
  ...defaultConfig,
  externals: {
    jquery: "jQuery",
  },
  entry: {
    frontend: path.resolve(__dirname, "src", "index.js"), // for the front end.
    frontend_rtl: path.resolve(__dirname, "src", "index_rtl.js"), // for the front end.
    admin: path.resolve(__dirname, "src/admin/", "admin_index.js"), // for the admin panel.
    admin_rtl: path.resolve(__dirname, "src/admin/", "admin_index_rtl.js"), // for the admin panel.
  },
  output: {
    path: path.resolve(__dirname, "assets"),
    filename: "scripts/[name].js",
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "styles/[name].css", // relative to output.path
    }),
  ],
}
