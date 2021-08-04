// Init Gulp.
var gulp = require('gulp')
  , uglify = require("gulp-uglify")
  , sass = require("gulp-sass")
  , minifyCss = require("gulp-minify-css")
  , rename = require("gulp-rename");

// Init paths.
var paths = {
  scripts: ['./assets/js/src/*.js', './assets/js/vendor/*.js'],
  styles: './assets/sass/*.scss'
};

// Minify JS.
gulp.task('scripts', function () {
  gulp.src(paths.scripts)
    .pipe(uglify())
    .pipe(rename(function (path) {
      path.basename += ".min";
    }))
    .pipe(gulp.dest('assets/js/dist'));
});

// Compile SASS.
gulp.task('styles', function () {
  gulp.src(paths.styles)
    .pipe(sass())
    .pipe(minifyCss())
    .pipe(rename(function (path) {
      path.basename += ".min";
    }))
    .pipe(gulp.dest('assets/css'));
});

// Re-run the tasks when files change.
gulp.task('watch', function() {
  gulp.watch(paths.scripts, ['scripts']);
  gulp.watch(paths.styles, ['styles']);
});

// The default task.
gulp.task('default', ['watch', 'scripts', 'styles']);
