const webpackConfig = require('./webpack.config.js');

module.exports = function (grunt) {
	grunt.initConfig({
		webpack: {
			myConfig: webpackConfig,
		}
	});

	grunt.loadNpmTasks('grunt-webpack');
};
