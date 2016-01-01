var gulp = require('gulp'),
    rename = require('gulp-rename')
    less = require('gulp-less');

gulp.task('compress', function() {
  gulp.src('less/*.less')
    .pipe(less())
	.pipe(rename({extname: '.css'}))
	.pipe(gulp.dest('css'))
});

// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch('less/*.less', ['compress']);
});

gulp.task('default', function() {
    gulp.start('compress');
});
