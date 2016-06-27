/**
 * Gulp File
 * 
 * run `gulp build-less && gulp watch` on the command line
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

// Compile LESS to CSS
gulp.task('build-less', function() {
	const fileFilter = filter(['**/*', '!**/mixins.less', '!**/variables.less']);
    gulp.src('./public/less/*.less') // path to less file
        .pipe(fileFilter)
        .pipe(plumber())
        .pipe(less())
        .pipe(gulp.dest('./public/css/')) // path to css directory
    ;
});

// Get vendors' code
gulp.task('build-vendors', function() {
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
});

// Run the build process
gulp.task('run', ['build-less', 'build-vendors']);

// Watch all LESS files, then run build-less
gulp.task('watch', function() {
    gulp.watch('public/less/*.less', ['run'])
});

// Default will run the 'entry' task
gulp.task('default', ['watch', 'run']);
