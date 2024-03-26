const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const rename = require('gulp-rename');
const ts = require('gulp-typescript');
const terser = require('gulp-terser');
const browserSync = require('browser-sync').create();

const argv = require('yargs').argv;

const themesPath = './wp-content/themes/ill/';
const paths = {
  scss: themesPath + 'assets/scss/**/*.scss',
  ts: themesPath + 'assets/ts/**/*.ts', // TypeScriptファイルのパスを追加
};

function scssTask() {
  return src(paths.scss)
    .pipe(plumber())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(themesPath + 'dist/css'))

}

function tsTask() {
  return src(paths.ts)
    .pipe(plumber())
    .pipe(ts({
      noImplicitAny: true,
      outFile: 'main.min.js'
    }))
    .pipe(terser()) // JavaScriptファイルを圧縮
    .pipe(dest(themesPath + 'dist/js'))

}

function watchTask() {
  browserSync.init({
    proxy: "yourlocal.dev",
    open: true,
    notify: false,
    reloadOnRestart: true // これは常にtrueでも構いません
  });

  if (argv.reload) {
    // --reloadオプションがある場合のみ、ファイルの変更を監視してリロードする
    watch(paths.scss, series(scssTask, function(done) {
      browserSync.reload();
      done();
    }));
    watch(paths.ts, series(tsTask, function(done) {
      browserSync.reload();
      done();
    }));
    watch(themesPath + '**/*.php').on('change', browserSync.reload);
  } else {
    // --reloadオプションがない場合は、通常通りタスクを実行するがリロードはしない
    watch(paths.scss, scssTask);
    watch(paths.ts, tsTask);
  }
}

// 一回だけscssTaskとtsTaskを実行するデフォルトタスク
exports.default = series(parallel(scssTask, tsTask), watchTask);

// ファイルの変更を監視するタスク
exports.watch = watchTask;
exports.scssTask = scssTask;
exports.tsTask = tsTask;
