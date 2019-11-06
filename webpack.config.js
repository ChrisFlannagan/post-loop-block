const path = require('path');

module.exports = {
    entry: './assets/post-loop-block.js',
    output: {
        filename: 'post-loop-block.js',
        path: path.resolve(__dirname, 'assets/dist'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader'
                    }
                ]
            }
        ]
    }
};
