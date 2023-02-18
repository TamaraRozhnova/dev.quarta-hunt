const gulp = require('gulp');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const sass = require('gulp-sass')(require('sass'));

const configs = require('./configs');

const builder = {
    createTasks() {
        Object.keys(configs).forEach(type => {
            let groups = [];
            configs[type].forEach(config => {
                groups.push(config.groupName);
                this.createBuildTask(type, config);
                this.createWatchTask(type, config);
                this.createGroupTask(type, config);
            });
            this.createMainTask(type, groups);
        })
    },

    createBuildTask(type, config) {
        switch (type) {
            case 'scss':
                gulp.task(`${type}:${config.groupName}:build`, () => {
                    const files = [config.src];
                    if (config.exclude) {
                        config.exclude.forEach(source => {
                            files.push(`!${source}`);
                        })
                    }
                    if (config.dest.fileName) {
                        return gulp.src(files)
                            .pipe(sass())
                            .pipe(rename({basename: config.dest.fileName, extname: '.css'}))
                            .pipe(gulp.dest(config.dest.path));
                    }
                    return gulp.src(files)
                        .pipe(sass())
                        .pipe(gulp.dest(config.dest.path));
                });
                break;
            case 'js':
                gulp.task(`${type}:${config.groupName}:build`, () => {
                    const files = [config.src];
                    if (config.exclude) {
                        config.exclude.forEach(source => {
                            files.push(`!${source}`);
                        })
                    }
                    return gulp.src(files)
                        .pipe(uglify())
                        .pipe(concat(config.dest.fileName + '.js'))
                        .pipe(gulp.dest(config.dest.path))
                })
                break;
            default:
                break;
        }
    },

    createWatchTask(type, config) {
        gulp.task(`${type}:${config.groupName}:watch`, () => {
            const files = [config.watch];
            if (config.exclude) {
                config.exclude.forEach(source => {
                    files.push(`!${source}`);
                })
            }
            gulp.watch(files, gulp.series(`${type}:${config.groupName}:build`));
        })
    },

    createGroupTask(type, config) {
        gulp.task(`${type}:${config.groupName}`, gulp.series(
            `${type}:${config.groupName}:build`,
            `${type}:${config.groupName}:watch`
        ));
    },

    createMainTask(type, groups) {
        gulp.task(type, gulp.parallel(...groups.map(groupName => `${type}:${groupName}`)));
    }
}

builder.createTasks();