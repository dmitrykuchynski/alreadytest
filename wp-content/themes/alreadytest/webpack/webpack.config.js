const path = require('path');
const webpack = require('webpack');

// include the js minification plugin
const TerserPlugin = require('terser-webpack-plugin');
// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const HtmlWebpackPlugin = require('html-webpack-plugin');
const glob = require('glob');

const entryPoints = glob.sync('./src/js/{*.js,pages/**/*.js,gutenberg/**/*.js}').reduce((entries, file) => {
  const relativePath = path.relative('./src/js', file);
  const name = relativePath.replace(/\\/g, '/').replace(/\.js$/, '');
  entries[name] = file;
  return entries;
}, {});

module.exports = (env, argv) => {

  const isDev = argv.mode === 'development'

  return {
    mode: isDev? 'development' : "production",
    entry: entryPoints,
    output: {
      filename: '../assets/js/[name].min.js',
      path: path.resolve(__dirname)
    },
    performance: {
      hints: false,
      maxEntrypointSize: 1024,
      maxAssetSize: 1024
    },
    module: {
      rules: [
        // perform js babelization on all .js files
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: "babel-loader",
          }
        },
        {
          test: /\.css$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            'postcss-loader'
          ]
        },
        // compile all .scss files to plain old css
        {
          test: /\.(sass|scss)$/,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader']
        },
        {
          test: /\.(woff(2)?|ttf|eot)$/,
          type: 'asset/resource',
          generator: {
            filename: '../assets/fonts/[name][ext]',
          },
        },
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
          type: 'asset/resource',
          generator: {
            filename: '../assets/images/[name][ext]'
          }
        }
      ]
    },
    plugins: [
      new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery"
      }),
      // extract css into dedicated file
      new MiniCssExtractPlugin({
        filename: '../assets/css/[name].min.css'
      }),
      new HtmlWebpackPlugin({
        inject: 'body',
        scriptLoading: 'defer',
        minify: {
          removeComments: true,
          collapseWhitespace: true,
        },
        preload: [
          {
            rel: 'preload',
            href: '../assets/fonts/[name][ext]',
            as: 'font',
            type: 'font/woff2',
            crossorigin: 'anonymous'
          }
        ]
      }),
    ],
    optimization: {
      minimize: true,
      minimizer: [
        // enable the js minification plugin
        new TerserPlugin ({
          parallel: true
        }),
        // enable the css minification plugin
        new CssMinimizerPlugin()
      ]
    }
  };
}

