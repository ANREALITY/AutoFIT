/**
 * Gulp File
 *
 * run `gulp run && gulp watch-files` on the command line
 */

// Include Gulp plugins
var gulp = require('gulp'),
    less = require('gulp-less'),
    watch = require('gulp-watch'),
    prefix = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber'),
    filter = require('gulp-filter'),
    rename = require('gulp-rename'),
    path = require('path')
;

// paths
// var paths = {
//     css: {
//         // By using styles/**/*.sass we're telling gulp to check all folders for any sass file
//         src: "./public/less/*.less",
//         // Compiled files will end up in whichever folder it's found in (partials are not compiled)
//         dest: "./public/css/"
//     }
//
//     // ,js: {
//     //  src: '...',
//     //  dest: '...'
//     // }
//
//     // ,html: {
//     //  src: '...',
//     //  dest: '...'
//     // }
// };

// Compile LESS to CSS
function buildLess(done) {
	const fileFilter = filter(['**/*', '!**/mixins.less', '!**/variables.less']);
    gulp.src('./public/less/*.less') // path to less file
        .pipe(fileFilter)
        .pipe(plumber())
        .pipe(less())
        .pipe(gulp.dest('./public/css/')) // path to css directory
    ;
    done();
};

// Get vendors' code
function buildVendors(done) {
    gulp.src(['./public/components/bootstrap/less/theme.less', './public/components/bootstrap/less/bootstrap.less']) // path to less file
        .pipe(plumber())
        .pipe(less())
        .pipe(rename(function (path) {
            //rename all files except 'bootstrap.css'
            if (path.basename + path.extname !== 'bootstrap.css') {
                path.basename = 'bootstrap-' + path.basename;
            }
        }))
        .pipe(gulp.dest('./public/css')) // path to css directory
    ;
    done();
};

// Watch all LESS files, then run build-less
function watchFiles() {
    gulp.watch(['public/less/*.less'], gulp.series('build-less'));
};

gulp.task('build-less', buildLess);
gulp.task('build-vendors', buildVendors);
gulp.task('run', gulp.series('build-less', 'build-vendors'));
gulp.task('watch-files', gulp.series(watchFiles));
gulp.task('default', gulp.series('run', 'watch-files'));

