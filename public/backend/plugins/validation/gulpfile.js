/**
 *
 * Gulpfile.js
 *
 */

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    csso = require('gulp-csso'),
    srcfiles = ['src/jquery.formValid.js'],
    srccss = ['src/jquery.formValid.css'],
    distdir = 'dist',
    compression = {
        output: {
            max_line_len: 150
        }
    };

gulp.task('build-js', function () {
    return gulp.src(srcfiles)
        .pipe(concat('jquery.formValid.min.js'))
        .pipe(uglify(compression))
        .pipe(gulp.dest(distdir));
});

gulp.task('copy-js', function () {
    return gulp.src(srcfiles)
        .pipe(gulp.dest(distdir));
});

gulp.task('build-css', function () {
    return gulp.src(srccss)
        .pipe(concat('jquery.formValid.min.css'))
        .pipe(csso())
        .pipe(gulp.dest(distdir));
});

gulp.task('copy-css', function () {
    return gulp.src(srccss)
        .pipe(gulp.dest(distdir));
});

gulp.task('watch', function () {
    gulp.watch('src/*.js', ['build-js']);
    gulp.watch('src/*.css', ['build-css']);
});

gulp.on('err', function (err) {
    console.log(err);
});

gulp.task('default', ['copy-js', 'build-js', 'copy-css', 'build-css']);
