var gulp = require('gulp');

// var UndertakerRegistry = require('undertaker-registry');
// var registry = new UndertakerRegistry();
// gulp.registry(registry);


var browserSync = require('browser-sync');





gulp.task('default', function() {
  browserSync({
    proxy: 'http://localhost/__perso/workbench/public/'
  });

  gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
});


// for exemple =======================================
// var connect = require('gulp-connect-php');
// gulp.task('sync', function() {
//     connect.server({}, function (){
//       browserSync({
//         proxy: 'localhost:8080'
//       });
//     });

//     gulp.watch('**/*.php').on('change', function () {
//       browserSync.reload();
//     });
// });

