// @remove-on-eject-begin
/**
 * Copyright (c) 2018-present, Elegant Themes, Inc.
 * Copyright (c) 2015-2018, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
// @remove-on-eject-end
'use strict';

const autoprefixer = require('autoprefixer');
const path = require('path');
const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const eslintFormatter = require('divi-dev-utils/eslintFormatter');
const ModuleScopePlugin = require('divi-dev-utils/ModuleScopePlugin');
const paths = require('./paths');
const getClientEnvironment = require('./env');
const glob = require('divi-dev-utils/glob');

const licenseFileRelativePath = '../license.txt';

// Webpack uses `publicPath` to determine where the app is being served from.
// It requires a trailing slash, or the file assets will get an incorrect path.
const publicPath = paths.servedPath;
// Some apps do not use client-side routing with pushState.
// For these, "homepage" can be set to "." to enable relative asset paths.
const shouldUseRelativeAssetPaths = publicPath === './';
// Source maps are resource heavy and can cause out of memory issue for large source files.
const shouldUseSourceMap = process.env.GENERATE_SOURCEMAP === 'true';
// `publicUrl` is just like `publicPath`, but we will provide it to our app
// as %PUBLIC_URL% in `index.html` and `process.env.PUBLIC_URL` in JavaScript.
// Omit trailing slash as %PUBLIC_URL%/xyz looks better than %PUBLIC_URL%xyz.
const publicUrl = publicPath.slice(0, -1);
// Get environment variables to inject into our app.
const env = getClientEnvironment(publicUrl);

// Assert this just to be safe.
// Development builds of React are slow and not intended for production.
if (env.stringified['process.env'].NODE_ENV !== '"production"') {
  throw new Error('Production builds must have NODE_ENV=production.');
}

// Note: defined here because it will be used more than once.
const cssFrontendFreeFilename = 'styles/style-free.min.css';
const cssFrontendProFilename = 'styles/style-pro.min.css';
const cssBackendFreeFilename = 'styles/backend-style-free.min.css';
const cssBackendProFilename = 'styles/backend-style-pro.min.css';

// Initiate ExtractTextPlugin instance for frontend and backend styles.
const extractTextPluginFrontendFree = new ExtractTextPlugin(cssFrontendFreeFilename);
const extractTextPluginFrontendPro = new ExtractTextPlugin(cssFrontendProFilename);
const extractTextPluginBackendFree = new ExtractTextPlugin(cssBackendFreeFilename);
const extractTextPluginBackendPro = new ExtractTextPlugin(cssBackendProFilename);

// ExtractTextPlugin expects the build output to be flat.
// (See https://github.com/webpack-contrib/extract-text-webpack-plugin/issues/27)
// However, our output is structured with css, js and media folders.
// To have this structure working with relative paths, we have to use custom options.
const extractTextPluginFrontendOptions = shouldUseRelativeAssetPaths
  ? // Making sure that the publicPath goes back to to build folder.
    { publicPath: Array(cssFrontendFilename.split('/').length).join('../') }
  : {};

const extractTextPluginBackendOptions = shouldUseRelativeAssetPaths
  ? // Making sure that the publicPath goes back to to build folder.
    { publicPath: Array(cssBackendFilename.split('/').length).join('../') }
  : {};

// Options for PostCSS as we reference these options twice
// Adds vendor prefixing based on your specified browser support in
// package.json
const postCSSLoaderOptions = {
  // Necessary for external CSS imports to work
  // https://github.com/facebook/create-react-app/issues/2677
  ident: 'postcss',
  plugins: () => [
    require('postcss-flexbugs-fixes'),
    autoprefixer({
      flexbox: 'no-2009',
    }),
  ],
};

// This is the production configuration.
// It compiles slowly and is focused on producing a fast and minimal bundle.
// The development configuration is different and lives in a separate file.
module.exports = {
  // Don't attempt to continue if there are any errors.
  bail: true,
  // We generate sourcemaps in production. This is slow but gives good results.
  // You can exclude the *.map files from the build during deployment.
  devtool: shouldUseSourceMap ? 'source-map' : false,
  // In production, we only want to load the polyfills and the app code.
  entry: {
    'builder-bundle-free': [
      require.resolve('./polyfills'),
      paths.appIndexJs,
	  paths.appPath + '/includes/free/loader.js',
      ...glob.sync([
        `${paths.appSrc}/modules/**/style.css`,
        `${paths.appSrc}/modules/**/style.scss`,
        `${paths.appSrc}/fields/**/style.css`,
        `${paths.appSrc}/fields/**/style.scss`,
        `${paths.appSrc}/fields/backend.scss`,

      ]),
    ],
    'builder-bundle-pro': [
      require.resolve('./polyfills'),
      paths.appIndexJs,
	  paths.appPath + '/includes/pro/loader.js',
      ...glob.sync([
        `${paths.appSrc}/modules/**/style.css`,
        `${paths.appSrc}/modules/**/style.scss`,
        `${paths.appSrc}/fields/**/style.css`,
        `${paths.appSrc}/fields/**/style.scss`,
        `${paths.appSrc}/fields/backend.scss`,

      ]),
    ],
	'frontend-bundle-free': [
      `${paths.appBuild}/scripts/frontend.js`
    ],
	'frontend-bundle-pro': [
      `${paths.appBuild}/scripts/frontend.js`
    ]
  },
  output: {
	pathinfo: true,
    // The build folder.
    path: paths.appBuild,
    // Generated JS file names (with nested folders).
    // There will be one main bundle, and one file per asynchronous chunk.
    // We don't currently advertise code splitting but Webpack supports it.
    filename: 'scripts/[name].min.js',
    chunkFilename: 'scripts/[name].chunk.js',
    // We inferred the "public path" (such as / or /my-project) from homepage.
    publicPath: publicPath,
    // Point sourcemap entries to original disk location (format as URL on Windows)
    devtoolModuleFilenameTemplate: info =>
      path
        .relative(paths.appSrc, info.absoluteResourcePath)
        .replace(/\\/g, '/'),
  },
  resolve: {
    // This allows you to set a fallback for where Webpack should look for modules.
    // We placed these paths second because we want `node_modules` to "win"
    // if there are any conflicts. This matches Node resolution mechanism.
    // https://github.com/facebook/create-react-app/issues/253
    modules: ['node_modules'].concat(
      // It is guaranteed to exist because we tweak it in `env.js`
      process.env.NODE_PATH.split(path.delimiter).filter(Boolean)
    ),
    // These are the reasonable defaults supported by the Node ecosystem.
    // We also include JSX as a common component filename extension to support
    // some tools, although we do not recommend using it, see:
    // https://github.com/facebook/create-react-app/issues/290
    // `web` extension prefixes have been added for better support
    // for React Native Web.
    extensions: ['.web.js', '.mjs', '.js', '.json', '.web.jsx', '.jsx'],
    alias: {
      // @remove-on-eject-begin
      // Resolve Babel runtime relative to react-scripts.
      // It usually still works on npm 3 without this but it would be
      // unfortunate to rely on, as react-scripts could be symlinked,
      // and thus @babel/runtime might not be resolvable from the source.
      '@babel/runtime': path.dirname(
        require.resolve('@babel/runtime/package.json')
      ),
      // @remove-on-eject-end
      // Support React Native Web
      // https://www.smashingmagazine.com/2016/08/a-glimpse-into-the-future-with-react-native-for-web/
      'react-native': 'react-native-web',
    },
    plugins: [
      // Prevents users from importing files from outside of src/ (or node_modules/).
      // This often causes confusion because we only process files within src/ with babel.
      // To fix this, we prevent you from importing files out of src/ -- if you'd like to,
      // please link the files into your node_modules/ and let module-resolution kick in.
      // Make sure your source files are compiled, as they will not be processed in any way.
      new ModuleScopePlugin(paths.appSrc, [paths.appPackageJson]),
    ],
  },
  externals: {
    jquery: 'jQuery',
    underscore: '_',
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  module: {
    strictExportPresence: true,
    rules: [
      // Disable require.ensure as it's not a standard language feature.
      { parser: { requireEnsure: false } },

      // First, run the linter.
      // It's important to do this before Babel processes the JS.
      {
        test: /\.(js|jsx|mjs)$/,
        enforce: 'pre',
        use: [
          {
            options: {
              formatter: eslintFormatter,
              eslintPath: require.resolve('eslint'),
              // TODO: consider separate config for production,
              // e.g. to enable no-console and no-debugger only in production.
              baseConfig: {
                extends: [require.resolve('eslint-config-divi-extension')],
              },
              // @remove-on-eject-begin
              ignore: false,
              useEslintrc: false,
              // @remove-on-eject-end
            },
            loader: require.resolve('eslint-loader'),
          },
        ],
        include: paths.srcPaths,
        exclude: [/[/\\\\]node_modules|scripts[/\\\\]/],
      },
      {
        // "oneOf" will traverse all following loaders until one will
        // match the requirements. When no loader matches it will fall
        // back to the "file" loader at the end of the loader list.
        oneOf: [
          // "url" loader works just like "file" loader but it also embeds
          // assets smaller than specified size as data URLs to avoid requests.
          {
            test: [/\.bmp$/, /\.gif$/, /\.jpe?g$/, /\.png$/],
            loader: require.resolve('url-loader'),
            options: {
              limit: 10000,
              name: 'media/[name].[ext]',
            },
          },
          // Process application JS with Babel.
          // The preset includes JSX, Flow, and some ESnext features.
          {
            test: /\.(js|jsx|mjs)$/,
            include: paths.srcPaths,
            exclude: [/[/\\\\]node_modules[/\\\\]/],
            use: [
              // This loader parallelizes code compilation, it is optional but
              // improves compile time on larger projects
              require.resolve('thread-loader'),
              {
                loader: require.resolve('babel-loader'),
                options: {
                  // @remove-on-eject-begin
                  babelrc: false,
                  // @remove-on-eject-end
                  presets: [require.resolve('babel-preset-divi-extension')],
                  plugins: [
                    [
                      require.resolve('babel-plugin-named-asset-import'),
                      {
                        loaderMap: {
                          svg: {
                            ReactComponent: 'svgr/webpack![path]',
                          },
                        },
                      },
                    ],
                  ],
                  compact: false,
                  highlightCode: true,
                },
              },
            ],
          },
          // Process any JS outside of the app with Babel.
          // Unlike the application JS, we only compile the standard ES features.
          {
            test: /\.js$/,
            use: [
              // This loader parallelizes code compilation, it is optional but
              // improves compile time on larger projects
              require.resolve('thread-loader'),
              {
                loader: require.resolve('babel-loader'),
                options: {
                  babelrc: false,
                  compact: false,
                  presets: [
                    require.resolve('babel-preset-divi-extension/dependencies'),
                  ],
                  cacheDirectory: true,
                  highlightCode: true,
                },
              },
            ],
          },
          // The notation here is somewhat confusing.
          // "postcss" loader applies autoprefixer to our CSS.
          // "css" loader resolves paths in CSS and adds assets as dependencies.
          // "style" loader normally turns CSS into JS modules injecting <style>,
          // but unlike in development configuration, we do something different.
          // `ExtractTextPlugin` first applies the "postcss" and "css" loaders
          // (second argument), then grabs the result CSS and puts it into a
          // separate file in our build process. This way we actually ship
          // a single CSS file in production instead of JS code injecting <style>
          // tags. If you use code splitting, however, any async bundles will still
          // use the "style" loader inside the async code so CSS from them won't be
          // in the main CSS file.
          // By default we support CSS Modules with the extension .module.css
          {
            test: /\.(s?css|sass)$/,
            exclude: [/assets/, /\.module\.css$/, /fields/, /pro/],
            use: extractTextPluginFrontendFree.extract(
              Object.assign(
                {
                  fallback: {
                    loader: require.resolve('style-loader'),
                    options: {
                      hmr: false,
                    },
                  },
                  use: [
                    {
                      loader: require.resolve('css-loader'),
                      options: {
                        importLoaders: 1,
                        minimize: false,
                        sourceMap: shouldUseSourceMap,
                      },
                    },
                    {
                      loader: require.resolve('postcss-loader'),
                      options: postCSSLoaderOptions,
                    },
                    {
                      loader: require.resolve('sass-loader'),
                      options: {
                        sourceMap: shouldUseSourceMap,
						outputStyle: 'expanded',
						sassOptions: {
							outputStyle: 'expanded',
							style: 'expanded'
						}
                      },
                    },
                  ],
                },
                extractTextPluginFrontendOptions
              )
            ),
            // Note: this won't work without `new ExtractTextPlugin()` in `plugins`.
          },
		  {
            test: /\.(s?css|sass)$/,
            exclude: [/assets/, /\.module\.css$/, /fields/],
            use: extractTextPluginFrontendPro.extract(
              Object.assign(
                {
                  fallback: {
                    loader: require.resolve('style-loader'),
                    options: {
                      hmr: false,
                    },
                  },
                  use: [
                    {
                      loader: require.resolve('css-loader'),
                      options: {
                        importLoaders: 1,
                        minimize: false,
                        sourceMap: shouldUseSourceMap,
                      },
                    },
                    {
                      loader: require.resolve('postcss-loader'),
                      options: postCSSLoaderOptions,
                    },
                    {
                      loader: require.resolve('sass-loader'),
                      options: {
                        sourceMap: shouldUseSourceMap,
						outputStyle: 'expanded',
						sassOptions: {
							outputStyle: 'expanded',
							style: 'expanded'
						}
                      },
                    },
                  ],
                },
                extractTextPluginFrontendOptions
              )
            ),
            // Note: this won't work without `new ExtractTextPlugin()` in `plugins`.
          },
          // Adds support for backend CSS such as custom fields and group it up as
          // backend-style CSS.
          {
            test: /\.(s?css|sass)$/,
            exclude: [/modules/, /assets/, /pro/],
            use: extractTextPluginBackendFree.extract(
              Object.assign(
                {
                  fallback: {
                    loader: require.resolve('style-loader'),
                    options: {
                      hmr: false,
                    },
                  },
                  use: [
                    {
                      loader: require.resolve('css-loader'),
                      options: {
                        minimize: false,
                        sourceMap: shouldUseSourceMap,
                      },
                    },
                    {
                      loader: require.resolve('sass-loader'),
                      options: {
                        sourceMap: shouldUseSourceMap,
						outputStyle: 'expanded',
						sassOptions: {
							outputStyle: 'expanded',
							style: 'expanded'
						}
                      },
                    },
                  ],
                },
                extractTextPluginBackendOptions
              )
            ),
          },
          {
            test: /\.(s?css|sass)$/,
            exclude: [/modules/, /assets/],
            use: extractTextPluginBackendPro.extract(
              Object.assign(
                {
                  fallback: {
                    loader: require.resolve('style-loader'),
                    options: {
                      hmr: false,
                    },
                  },
                  use: [
                    {
                      loader: require.resolve('css-loader'),
                      options: {
                        minimize: false,
                        sourceMap: shouldUseSourceMap,
                      },
                    },
                    {
                      loader: require.resolve('sass-loader'),
                      options: {
                        sourceMap: shouldUseSourceMap,
						outputStyle: 'expanded',
						sassOptions: {
							outputStyle: 'expanded',
							style: 'expanded'
						}
                      },
                    },
                  ],
                },
                extractTextPluginBackendOptions
              )
            ),
          },
          // "file" loader makes sure assets end up in the `build` folder.
          // When you `import` an asset, you get its filename.
          // This loader doesn't use a "test" so it will catch all modules
          // that fall through the other loaders.
          {
            loader: require.resolve('file-loader'),
            // Exclude `js` files to keep "css" loader working as it injects
            // it's runtime that would otherwise be processed through "file" loader.
            // Also exclude `html` and `json` extensions so they get processed
            // by webpacks internal loaders.
            exclude: [/\.(js|jsx|mjs)$/, /\.html$/, /\.json$/],
            options: {
              name: 'media/[name].[ext]',
            },
          },
          // ** STOP ** Are you adding a new loader?
          // Make sure to add the new loader(s) before the "file" loader.
        ],
      },
    ],
  },
  plugins: [
    // Makes some environment variables available to the JS code, for example:
    // if (process.env.NODE_ENV === 'production') { ... }. See `./env.js`.
    // It is absolutely essential that NODE_ENV was set to production here.
    // Otherwise React will be compiled in the very slow development mode.
    new webpack.DefinePlugin(env.stringified),

	// AGS custom plugin - save non-minified copies of files
	function() {
		const path = require('path');
		const postcss = require('postcss');
		const cssnano = require('cssnano');
		const sources = require('webpack-sources');
		const prefixer = require('postcss-prefix-selector');

		this.plugin('compilation', function (webpackCompilation) {
			webpackCompilation.plugin('optimize-chunk-assets', function(files, doneCb) {

				// Save the unmninified JS and CSS files without the .min suffix, prepending a header comment
				function saveUnminifiedFiles() {
					for (var file in webpackCompilation.assets) {
                        if (file.indexOf('.min') !== -1) {
                            webpackCompilation.assets[file.replace('.min.', '.')] = new sources.RawSource(
                                '/*! For licensing and copyright information applicable to the product that this file belongs to, please see ' + licenseFileRelativePath + '. */\n'
                                + webpackCompilation.assets[file].source()
                            );
                        }
                    }
				}

				// Since we had to disable CSS minification in the CSS/SASS loaders to get the unminified source, we need to minify CSS here
				function minifyCssFiles() {
					var minCssProcessed = 0;

					var minCssFiles = Object.keys(webpackCompilation.assets).filter( function (file) {
						return file.indexOf('.min.css') !== -1;
					} );

					if (minCssFiles.length) {
						minCssFiles.map( function(file) {
							postcss( [cssnano] ).process(webpackCompilation.assets[file].source()).then( function(minifyResult) {
								webpackCompilation.assets[file] = new sources.RawSource(minifyResult.css);
								if (++minCssProcessed === minCssFiles.length) {
									doneCb();
								}
							} );
						} );

					} else {
						doneCb();
					}
				}
				
				if ( webpackCompilation.assets['styles/backend-style-free.min.css'] ) {
					var backendStylePro = new sources.ConcatSource( webpackCompilation.assets['styles/backend-style-free.min.css'] );
					if (webpackCompilation.assets['styles/backend-style-pro.min.css']) {
						backendStylePro.add( webpackCompilation.assets['styles/backend-style-pro.min.css'] );
					}
					webpackCompilation.assets['styles/backend-style-pro.min.css'] = backendStylePro;
				}
				
				if ( webpackCompilation.assets['styles/style-free.min.css'] ) {
					var stylePro = new sources.ConcatSource( webpackCompilation.assets['styles/style-free.min.css'] );
					if (webpackCompilation.assets['styles/style-pro.min.css']) {
						stylePro.add( webpackCompilation.assets['styles/style-pro.min.css'] );
					}
					webpackCompilation.assets['styles/style-pro.min.css'] = stylePro;
				}

				if ( webpackCompilation.assets['styles/style-free.min.css'] && webpackCompilation.assets['styles/style-pro.min.css'] ) {

					// Generate the style-dbp file
					// Moved here from divi-scripts-modified\scripts\build.js (and modified)
					postcss(
						prefixer({
							prefix: '.et_divi_builder #et_builder_outer_content',
							exclude: [],

							// Optional transform callback for case-by-case overrides
								/*transform: function(prefix, selector, prefixedSelector) {
							  if (selector === 'body') {
								return 'body.' + prefix;
							  } else {
								return prefixedSelector;
							  }
							}*/
						})
					).process(webpackCompilation.assets['styles/style-free.min.css'].source()).then( function(prefixResult) {
						webpackCompilation.assets['styles/style-free-dbp.min.css'] = new sources.RawSource(prefixResult.css);
						
						// Generate the style-dbp file
						// Moved here from divi-scripts-modified\scripts\build.js (and modified)
						postcss(
							prefixer({
								prefix: '.et_divi_builder #et_builder_outer_content',
								exclude: [],

								// Optional transform callback for case-by-case overrides
									/*transform: function(prefix, selector, prefixedSelector) {
								  if (selector === 'body') {
									return 'body.' + prefix;
								  } else {
									return prefixedSelector;
								  }
								}*/
							})
						).process(webpackCompilation.assets['styles/style-pro.min.css'].source()).then( function(prefixResult) {
							webpackCompilation.assets['styles/style-pro-dbp.min.css'] = new sources.RawSource(prefixResult.css);
							saveUnminifiedFiles();
							minifyCssFiles();
						} );
					} );

				} else {
					saveUnminifiedFiles();
					minifyCssFiles();
				}

			});
		});
	},

    // Minify the code.
    new UglifyJsPlugin({
	  // Don't minify the *.js (non-min) files that have been added
	  test: /\.min\.js$/,
      uglifyOptions: {
        ecma: 8,
        compress: {
          warnings: false,
          // Disabled because of an issue with Uglify breaking seemingly valid code:
          // https://github.com/facebook/create-react-app/issues/2376
          // Pending further investigation:
          // https://github.com/mishoo/UglifyJS2/issues/2011
          comparisons: false,
        },
        mangle: {
          safari10: true,
        },
        output: {
          comments: /^\**!|@preserve|@license|@cc_on/,
          // Turned on because emoji and regex is not minified properly using default
          // https://github.com/facebook/create-react-app/issues/2488
          ascii_only: true,
        },
      },
      // Use multi-process parallel running to improve the build speed
      // Default number of concurrent runs: os.cpus().length - 1
      parallel: true,
      // Enable file caching
      cache: true,
      sourceMap: shouldUseSourceMap,
    }),
	new webpack.BannerPlugin({
		banner: '/*! For licensing and copyright information applicable to the product that this file belongs to, please see ' + licenseFileRelativePath + '. A non-minified version of this file is available in the same directory (remove .min from the filename). */',
		raw: true
	}),
    // Note: this won't work without ExtractTextPlugin.extract(..) in `loaders`.
    extractTextPluginFrontendFree,
    extractTextPluginFrontendPro,
    extractTextPluginBackendFree,
    extractTextPluginBackendPro,
    // Generate a manifest file which contains a mapping of all asset filenames
    // to their corresponding output file so that tools can pick it up without
    // having to parse `index.html`.
    new ManifestPlugin({
      fileName: 'asset-manifest.json',
      publicPath: publicPath,
    }),
    // Moment.js is an extremely popular library that bundles large locale files
    // by default due to how Webpack interprets its code. This is a practical
    // solution that requires the user to opt into importing specific locales.
    // https://github.com/jmblog/how-to-optimize-momentjs-with-webpack
    // You can remove this if you don't use Moment.js:
    new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
  ],
  // Some libraries import Node modules but don't use them in the browser.
  // Tell Webpack to provide empty mocks for them so importing them works.
  node: {
    dgram: 'empty',
    fs: 'empty',
    net: 'empty',
    tls: 'empty',
    child_process: 'empty',
  },
};
