const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssoWebpackPlugin = require('csso-webpack-plugin').default;
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

const pathSrc = '../src/upload/admin/view/';
const pathDist = '../src/upload/admin/view/dist/';

const dir = {
  javascript: path.join(__dirname, pathSrc + 'javascript/ultimaterial/'),
  scss: path.join(__dirname, pathSrc + 'stylesheet/ultimaterial/scss/'),
  output: path.join(__dirname, pathDist)
};

module.exports = [
  {
    entry: {
      'stylesheet/stylesheet': dir.scss + 'stylesheet.scss',
      'stylesheet/template/extension/theme/ultimaterial/framework': dir.scss + 'template/extension/theme/ultimaterial/framework.scss',
      'stylesheet/template/extension/theme/ultimaterial': dir.scss + 'template/extension/theme/ultimaterial.scss',
      'javascript/config/input/range': dir.javascript + 'config/input/range.js',
      'javascript/template/extension/theme/ultimaterial/framework': dir.javascript + 'template/extension/theme/ultimaterial/framework.js',
    },
    output: {
      filename: '[name].js',
      path: path.resolve(__dirname, dir.output)
    },
    module: {
      rules: [
        {
          test: /\.s[ac]ss$/,
          use: [
            "style-loader",
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                url: false
              }
            },
            {
              loader: "postcss-loader"
            },
            {
              loader: "sass-loader",
              options: {
                implementation: require('sass')
              }
            }
          ]
        },
        {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: "babel-loader"
        }
      ]
    },
    plugins: [
      new CleanWebpackPlugin({
        dry: false,
        verbose: true,
        protectWebpackAssets: false,
        cleanAfterEveryBuildPatterns: ['stylesheet/**/*.js']
      }),
      new MiniCssExtractPlugin('[name].css'),
      new CssoWebpackPlugin({
        forceMediaMerge: true,
        comments: false
      })
    ]
  }
];
