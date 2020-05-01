const postcssLogical = require('postcss-logical');
const postcssPresetEnv = require('postcss-preset-env');

module.exports = {
  plugins: [
    require('autoprefixer'),
    postcssLogical(),
    postcssPresetEnv({
      autoprefixer: { grid: 'autoplace' }
    })
  ]
}
