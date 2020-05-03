const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssoWebpackPlugin = require('csso-webpack-plugin').default;
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

const pathSrc = '../src/upload/catalog/view/theme/ultimaterial/src/';
const pathDist = '../src/upload/catalog/view/theme/ultimaterial/dist/';

const dir = {
  javascript: path.join(__dirname, pathSrc + 'javascript/'),
  scss: path.join(__dirname, pathSrc + 'scss/'),
  output: path.join(__dirname, pathDist)
};

module.exports = [
  {
    entry: {
      'javascript/config/dialog': dir.javascript + 'config/dialog.js',
      'stylesheet/config/dialog': dir.scss + 'config/dialog.scss',
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
