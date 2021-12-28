const path = require('path');

module.exports = {
  entry: './src/index.js',
  mode: 'production', //add this line here
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'dist'),
  },
};