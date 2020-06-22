const webpack = require('webpack');
const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin');

const config = {
    entry: {
        app: ['./resources/js/app.js', './resources/scss/app.scss']
    },
    output: {
        path: path.resolve(__dirname, 'public'),
        filename: 'js/[name].js'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.(scss|sass|css)$/,
                use: [
                    'vue-style-loader',
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: function () {
                                return [
                                    require('autoprefixer')
                                ];
                            }
                        }
                    },
                    'sass-loader',
                ]
            }
        ]
    },
    resolve: {
        extensions: [
            '.js',
            '.vue',
            '.scss'
        ],
        alias: {
            vue$: 'vue/dist/vue.esm.js'
        }
    },
    plugins: [
        new VueLoaderPlugin(),
        new LodashModuleReplacementPlugin,
        new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /en/),
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
    ]
};

module.exports = config;