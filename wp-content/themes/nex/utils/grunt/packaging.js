/* jshint node:true */
module.exports = function(grunt) {
	'use strict';

	var path = require('path');

	var basedir = path.dirname(grunt.file.findup('Gruntfile.js'));
	var theme_name = grunt.file.readJSON(path.join(basedir, 'package.json')).name;
	var builddir = path.join(basedir, 'build', theme_name);

	var secrets_path = grunt.file.findup('secrets.json');
	var secrets = secrets_path ? require( secrets_path ) : {
		livepath: '',
		ssh_host: '',
		export_api_url: '',
		export_api_key: ''
	};

	function exportApiCall(action, callback) {
		var http = require('https');
		var url = secrets.export_api_url + secrets.export_api_key + '/' + action;

		grunt.log.writeln( url );

		http.get(url, function(res) {
			var body = '';

			res.on('data', function(chunk) {
				body += chunk;
			});

			res.on('end', function() {
				var response = body;

				try {
					response = JSON.parse(body.trim());
				} catch(e) {}

				if ( 'error' in response ) {
					return callback( response.error );
				}

				callback(null, response);
			});
		}).on('error', function(err) {
			callback(err);
		});
	}

	grunt.registerTask('scp-download-samples', function() {
		var done = this.async();

		var files = [
			['cache/all.css', 'samples/all-default.css'],
		], fi = -1;

		var next = function() {
			if(++fi >= files.length)
				return done();

			grunt.log.writeln('Downloading '+files[fi][0]+' to '+files[fi][1]);

			var exec = require('child_process').exec;

			var scp = grunt.template.process("scp <%= ssh_host %>:<%= remotepath %> <%= localpath %>", {
				data: {
					ssh_host: secrets.ssh_host,
					remotepath: path.join( grunt.template.process(secrets.livepath, grunt.config()), files[fi][0] ),
					localpath: path.join(builddir, files[fi][1]),
				}
			});

			exec(scp, function(error) {
				if(error) return done(grunt.util.error(error));

				next();
			});
		};

		next();
	});

	grunt.registerTask('download-layerslider', function() {
		var done = this.async();

		var exec = require('child_process').exec;
		var fs   = require("fs");

		var localdir = path.join(builddir, 'samples/layerslider/');
		grunt.file.mkdir(localdir);

		grunt.log.writeln('Downloading layerslider-export.zip');

		var temp_file = '/tmp/layerslider-export.zip';

		exportApiCall( 'layerslider', function(err, res) {
			if(err) return done(false);


			var curl = "curl -o " + temp_file + " " + res.exported;

			exec(curl, function(error) {
				if(error) return done(grunt.util.error(error));

				var data = grunt.file.read( temp_file, { encoding: 'binary' } );

				var Zip = require('node-zip');
				var spread = new Zip( data, { base64: false, checkCRC32: true});

				Object.keys(spread.files).forEach( function( f ) {
					if ( ! f.match( /json$/ ) ) {
						return true;
					}

					var single = new Zip();

					single.file( f, spread.file(f).asText() );

					var data = single.generate( { base64: false } );

					var spath = path.join( localdir, f.split( '/' )[0] );
					grunt.file.mkdir( spath );
					fs.writeFileSync( path.join( spath, 'slider.zip' ), data, 'binary' );

					grunt.file.copy( path.join( basedir, 'samples', 'small.png' ), path.join( spath, 'preview.png' ) );
				} );

				done();
			});
		});
	});

	grunt.registerTask('download-revslider', function() {
		var done = this.async();

		exportApiCall('revslider', function(err, res) {
			if(err) return done(grunt.util.error("API error:"+err));

			if ( res.length === 0 ) {
				done( grunt.util.error( 'No sliders found, possibly something went wrong.' ) );

				console.error( res );

				return;
			}

			var exec = require('child_process').exec;

			var localdir = path.join(builddir, 'samples/revslider/');
			grunt.file.mkdir(localdir);

			var ri = -1;

			var next = function() {
				if(++ri >= res.length)
					return done();

				grunt.log.writeln('Downloading '+res[ri]);

				var url = secrets.export_api_url + secrets.export_api_key + '/revslider-single/' + res[ri];

				var curl = "curl -o '" + path.join(localdir, res[ri] + '.zip') + "' '" + url + "'";

				exec(curl, function(error) {
					if(error) return done(grunt.util.error(error));

					next();
				});
			};

			next();
		});
	});

	grunt.registerTask('download-ninjaforms', function() {
		var done = this.async();

		exportApiCall('ninja-forms-list', function(err, res) {
			if ( err ) {
				done( grunt.util.error("API error: "+err ) );
				return;
			}

			if ( res.length === 0 ) {
				done( grunt.util.error( 'No forms found, possibly something went wrong.' ) );

				console.error( res );

				return;
			}

			var exec = require('child_process').exec;

			var localdir = path.join(builddir, 'samples/ninja-forms/');
			grunt.file.mkdir(localdir);

			var ri = -1;

			var next = function() {
				if(++ri >= res.length)
					return done();

				grunt.log.writeln('Downloading '+res[ri]);

				var url = secrets.export_api_url + secrets.export_api_key + '/ninja-forms-download/' + res[ri];

				var curl = "curl -o " + path.join(localdir, res[ri] + '.nff') + " " + url;

				exec(curl, function(error) {
					if(error) return done(grunt.util.error(error));

					next();
				});
			};

			next();
		});
	});

	grunt.registerTask('download-booked', function() {
		var done = this.async();

		exportApiCall('booked-settings', function(err, res) {
			if ( err ) {
				done( grunt.util.error("API error: " + err ) );
				return;
			}

			var exec = require('child_process').exec;

			var localpath = path.join(builddir, 'samples/booked-settings.json');

			grunt.file.write( localpath, JSON.stringify( res ) );

			done();
		});
	});

	grunt.registerTask('download-gmp-easy', function() {
		var done = this.async();

		var exec = require('child_process').exec;

		var localdir = path.join(builddir, 'samples/');

		var url = secrets.export_api_url + secrets.export_api_key + '/google-maps-easy-download';

		var curl = "curl -o " + path.join(localdir, 'gmp-easy.csv') + " " + url;

		grunt.log.writeln( url );

		exec(curl, function(error) {
			if ( error ) {
				return done( grunt.util.error( error ) );
			}

			done();
		});
	});

	grunt.registerTask('download-json', function( name ) {
		var done = this.async();

		exportApiCall( name, function(err, res) {
			if ( err ) {
				done( grunt.util.error("API error: " + err ) );
				return;
			}

			var exec = require('child_process').exec;

			var localpath = path.join(builddir, 'samples/', name + '.json');

			grunt.file.write( localpath, JSON.stringify( res ) )

			done();
		});
	});

	grunt.registerTask('check-api', function() {
		var done = this.async();

		exportApiCall('api-version', function(err, res) {
			if(err) return done(false);
			if(!('version' in res) || res.version < grunt.config('pkg').vamtamApi)
				return done(grunt.util.error("Old Export API. Please update the plugin to version " + grunt.config('pkg').vamtamApi));

			done();
		});
	});

	grunt.registerTask('download-sidebars-options', function() {
		var done = this.async();

		var parts = [
			['sidebars', 'sidebars', 'sidebars'],
			['default-options-beaver', 'default-options.php', 'options'],
		], pi = -1;

		var next = function() {
			if(++pi >= parts.length)
				return done();

			grunt.log.writeln('Downloading '+parts[pi][1]);

			exportApiCall(parts[pi][0], function(err, res) {
				if(err) return done(false);

				grunt.file.write(path.join(builddir, "samples", parts[pi][1]), res[parts[pi][2]].replace(/(\r\n|\r|\n)/g, "\n"));
				next();
			});
		};

		next();
	});

	grunt.registerTask('download-content-xml', function() {
		var done = this.async();

		exportApiCall('content.xml-beaver', function(err, res) {
			if(err) return done(grunt.util.error("API error:"+err));

			console.log(res);

			var exec = require('child_process').exec;
			var curl = "curl -o "+path.join(builddir, 'samples', 'content.xml')+" "+res.download_url;

			exec(curl, function(err) {
				if(err) return done(grunt.util.error(err));

				grunt.log.writeln("saved content.xml");
				done();
			});
		});
	});

	grunt.registerTask('download-images', function() {
		var done = this.async();

		var localdir = path.join(builddir, 'samples/images/');
		grunt.file.mkdir(localdir);

		exportApiCall('image-replacements', function(err, res) {
			if(!('images' in res))
				return done(grunt.util.error('No image info.'));

			var images = res.images.filter(function(s) { return s; }),
				i = 0;

			var next = function() {
				if(i >= images.length) return done();

				var image_url = images[i++];
				var localpath = path.join(localdir, path.basename(image_url));

				var exec = require('child_process').exec;
				var curl = "curl -o "+localpath+" "+image_url;

				exec(curl, function(err) {
					if(err) return done(grunt.util.error(err));

					grunt.log.writeln("saved: "+image_url);
					next();
				});
			};

			next();
		});
	});

	grunt.registerMultiTask('add-textdomain', function() {
		var files = grunt.file.expand(this.data);

		for(var fi in files) {
			grunt.file.write(files[fi],
				grunt.file.read(files[fi])
					.replace( /,\s*(['"])(vamtam|wpv)\1/g, ", '"+theme_name+"'")
					.replace( /(load_theme_textdomain|is_textdomain_loaded)\(\s*'(vamtam|wpv)'/g, "$1( '"+theme_name+"'")
			);
		}
	});

	grunt.registerTask('build-plugins', function() {
		var done = this.async();
		var prefix = 'vamtam/plugins/';

		var plugins = grunt.file.expand([
			prefix + '*',
			'!'+ prefix + '*.*',
		]);

		plugins.forEach(function(dirname) {
			var plugin_name = dirname.replace(prefix, '');

			grunt.config.set('compress.plugin-'+plugin_name, {
				options: {
					archive: prefix + plugin_name + '.zip',
					mode: 'zip',
					pretty: true,
					level: 9,
				},
				files: [{
					expand: true,
					src: [
						plugin_name + '/**/*',
						'!' + plugin_name + '/node_modules/**',
					],
					cwd: 'vamtam/plugins/'
				}]
			});

			grunt.task.run('compress:plugin-'+plugin_name);
		});

		done();
	});
};