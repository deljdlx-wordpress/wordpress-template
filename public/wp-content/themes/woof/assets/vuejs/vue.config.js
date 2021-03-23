module.exports = {
  filenameHashing: false,
  outputDir: 'dist',
  publicPath: './',


  chainWebpack: config => {
    config.plugins.delete('html');
    config.plugins.delete('preload');
    config.plugins.delete('prefetch');
  },

  devServer: {
    inline: false, // https://webpack.js.org/configuration/dev-server/#devserver-inline
    writeToDisk: true,
    hot: false,
  },
  //productionSourceMap: false
};
