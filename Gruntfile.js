const webpackConfig = require('./webpack.config.js');

module.exports = function (grunt) {
    grunt.initConfig({
        webpack: {
            myConfig: webpackConfig
        },
        watch: {
            all: {
                files: ['assets/js/*.js', 'assets/css/*.scss'],
                tasks: ['webpack']
            }
        }
    });

    grunt.loadNpmTasks('grunt-webpack');
    grunt.loadNpmTasks('grunt-contrib-watch');
};
