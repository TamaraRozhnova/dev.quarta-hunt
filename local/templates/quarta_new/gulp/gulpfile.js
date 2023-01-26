const gulp = require("gulp");
const rename = require("gulp-rename");
const sass = require("gulp-sass")(require('sass'));

gulp.task("styles:main", function () {
    return gulp.src("./../assets/styles/main.scss")
        .pipe(sass())
        .pipe(rename("template_styles.css"))
        .pipe(gulp.dest("../"))
})

gulp.task("styles:components", function () {
    return gulp.src("./../components/**/*.scss")
        .pipe(sass())
        .pipe(rename({
            extname: ".css"
        }))
        .pipe(gulp.dest("./../components/"))
})

gulp.task("styles", gulp.series("styles:main", "styles:components"));

gulp.task("watch", function() {
    gulp.watch("./../**/*.scss", gulp.series("styles:main", "styles:components"));
});