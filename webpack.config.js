const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssoWebpackPlugin = require('csso-webpack-plugin').default;
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

const pathSrc = './src/upload/catalog/view/theme/ultimaterial/src/';
const pathDist = './src/upload/catalog/view/theme/ultimaterial/dist/';

const dir = {
  javascript: path.join(__dirname, pathSrc + 'javascript/'),
  sass: path.join(__dirname, pathSrc + 'sass/'),
  font: path.join(__dirname, pathSrc + 'fonts/'),
  output: path.join(__dirname, pathDist)
};

module.exports = [
  {
    entry: {
      vendor: [
        'photoswipe',
        'photoswipe/src/js/ui/photoswipe-ui-default.js'
      ],
      'javascript/vendor/lazysizes': 'lazysizes',
      'javascript/common': dir.javascript + 'common.js',
      'javascript/common/cart': dir.javascript + 'template/common/cart.js',
      'javascript/common/home': dir.javascript + 'template/common/home.js',
      'javascript/account/login': dir.javascript + 'template/account/login.js',
      'javascript/account/manager': dir.javascript + 'template/account/manager.js',
      'javascript/account/register': dir.javascript + 'template/account/register.js',
      'javascript/product/product-list': dir.javascript + 'template/product/product-list.js',
      'javascript/product/product': dir.javascript + 'template/product/product.js',
      'javascript/extension/module/filter': dir.javascript + 'template/extension/module/filter.js',
      'javascript/extension/module/retail': dir.javascript + 'template/extension/module/retail.js',
      'stylesheet/vendor/nouislider/nouislider': dir.sass + 'vendor/nouislider/nouislider.scss',
      'stylesheet/stylesheet': dir.sass + 'stylesheet.scss',
      'stylesheet/template/account/account': dir.sass + 'template/account/account.scss',
      'stylesheet/template/account/login': dir.sass + 'template/account/login.scss',
      'stylesheet/template/account/manager': dir.sass + 'template/account/manager.scss',
      'stylesheet/template/account/register': dir.sass + 'template/account/register.scss',
      'stylesheet/template/common/home': dir.sass + 'template/common/home.scss',
      'stylesheet/template/common/cart': dir.sass + 'template/common/cart.scss',
      'stylesheet/template/checkout/checkout': dir.sass + 'template/checkout/checkout.scss',
      'stylesheet/template/error/not_found': dir.sass + 'template/error/not_found.scss',
      'stylesheet/template/extension/module/blog/article': dir.sass + 'template/extension/module/blog/article.scss',
      'stylesheet/template/extension/module/blog': dir.sass + 'template/extension/module/blog.scss',
      'stylesheet/template/extension/module/category': dir.sass + 'template/extension/module/category.scss',
      'stylesheet/template/extension/module/filter': dir.sass + 'template/extension/module/filter.scss',
      'stylesheet/template/extension/module/retail': dir.sass + 'template/extension/module/retail.scss',
      'stylesheet/template/product/product-list': dir.sass + 'template/product/product-list.scss',
      'stylesheet/template/product/product': dir.sass + 'template/product/product.scss'
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
      }),
      new webpack.ProvidePlugin({
        PhotoSwipe: 'photoswipe',
        PhotoSwipeUI_Default: 'photoswipe/src/js/ui/photoswipe-ui-default.js'
      })
    ]
  }
];
