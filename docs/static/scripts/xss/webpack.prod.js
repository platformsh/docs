const path = require('path')
const merge = require('webpack-merge')
const webpack = require('webpack')
const common = require('./webpack.common.js')
// const config = require("platformsh-config").config();

// module.exports = (env) => {
//     return merge(common, {
//         plugins: [
//             // new webpack.NamedModulesPlugin(),
//             // new webpack.HotModuleReplacementPlugin(),
//             new webpack.DefinePlugin({
//                 'process.env.MEILI_URL': env.MEILI_URL,
//                 'process.env.MEILI_INDEX': env.MEILI_INDEX,
//                 'process.env.MEILI_TOKEN': env.MEILI_TOKEN,
//             })
//         ]
//     })
// } 

module.exports = (env) => {
    // if (env.API_KEY) {
    //   console.log('\x1b[36m%s\x1b[0m', '\nAPI key loaded\n')
    // } else {
    //   console.log('\x1b[33m%s\x1b[0m', '\nWarning - No API_KEY declared\n')
    // }
  
    return merge(common, {
    //   devServer: {
    //     contentBase: path.join(__dirname, 'dist'),
    //     compress: true,
    //     historyApiFallback: true,
    //     hot: true,
    //     host: '0.0.0.0',
    //     disableHostCheck: true,
    //     open: true,
    //     // port: process.env.PORT,
    //     stats: 'minimal'
    //   },
    //   devtool: 'eval',
      plugins: [
        // new webpack.NamedModulesPlugin(),
        // new webpack.HotModuleReplacementPlugin(),
        new webpack.DefinePlugin({
            'process.env.MEILI_URL': env.MEILI_URL
        })
      ]
    })
  }