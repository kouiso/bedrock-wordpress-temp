const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const typescript = require('gulp-typescript');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const terser = require('gulp-terser');
const eslint = require('gulp-eslint').default;
const stylelint = require('gulp-stylelint');
const prettier = require('gulp-prettier');
const phpcs = require('gulp-phpcs');
const plumber = require('gulp-plumber');
const browserSync = require('browser-sync').create();

const themesPath = './web/app/themes/*/';
const paths = {
  scss: themesPath + 'assets/scss/**/*.scss',
  ts: themesPath + 'assets/ts/**/*.ts',
  php: themesPath + '**/*.php'
};

function scssTask() {
  return src(paths.scss)
    .pipe(plumber())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(dest(themesPath + 'assets/css'));
}

function tsTask() {
  return src(paths.ts)
    .pipe(plumber())
    .pipe(typescript({ noImplicitAny: true, outFile: 'script.js' }))
    .pipe(terser())
    .pipe(dest(themesPath + 'assets/js'));
}

function lintStyles() {
  return src(paths.scss)
    .pipe(stylelint({
      failAfterError: true,
      reportOutputDir: 'reports/lint',
      reporters: [
        {formatter: 'verbose', console: true},
        {formatter: 'json', save: 'report.json'},
      ],
      debug: true
    }));
}

function lintScripts() {
  return src(paths.ts)
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

function formatPHP() {
  return src(paths.php)
    .pipe(phpcs({
      bin: 'vendor/bin/phpcs',
      standard: 'WordPress',
      warningSeverity: 0
    }))
    .pipe(phpcs.reporter('log'))
    .pipe(phpcs.reporter('fail', {failOnFirst: false}));
}

function watchTask() {
  browserSync.init({
    proxy: 'your-local-dev-site.com'
  });
  watch([paths.scss, paths.ts, paths.php], 
    parallel(scssTask, tsTask, lintStyles, lintScripts, formatPHP)).on('change', browserSync.reload);
}

exports.default = series(
  parallel(scssTask, tsTask, lintStyles, lintScripts, formatPHP),
  watchTask
);
