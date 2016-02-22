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
    const fileFilter = filter(['*', '!mixins.less', '!variables.less']);
    gulp.src('./public/less/*.less') // path to less file
        .pipe(fileFilter)
        .pipe(plumber())
        .pipe(less())
        .pipe(gulp.dest('./public/css/')) // path to css directory
    ;
    gulp.src(['./public/components/bootstrap/less/theme.less', './public/components/bootstrap/less/bootstrap.less']) // path to less file
        .pipe(plumber())
        .pipe(less())
        .pipe(gulp.dest('./public/css/bootstrap')) // path to css directory
    ;
})

// Watch all LESS files, then run build-less
gulp.task('watch', function() {
    gulp.watch('public/less/*.less', ['build-less'])
});

// Default will run the 'entry' task
gulp.task('default', ['watch', 'build-less']);
