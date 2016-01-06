var gulp = require('gulp'),
    zip  = require('gulp-zip'),
    size = require('gulp-filesize'),
    tm   = require('node-tmhub').tmhub;

gulp.task('composer', function(cb) {
    tm.makeDirs(['vendor', 'code']);
    tm.generateComposerJson();
    tm.composerRefresh(cb);
});

gulp.task('full', ['composer'], function() {
    gulp.src(['code/**/*'])
        .pipe(zip(tm.getArchiveName()))
        .pipe(size())
        .pipe(gulp.dest('bin'));
});

gulp.task('default', ['full']);
