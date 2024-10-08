module.exports = Object.freeze(
    {
        scss: [
            {
                groupName: 'main',
                src: '../assets/styles/main.scss',
                dest: {path: '../', fileName: 'template_styles'},
                watch: '../assets/styles/**/*.scss'
            },
            {
                groupName: 'components',
                src: '../components/**/*.scss',
                dest: {path: '../components/', fileName: ''},
                watch: '../components/**/*.scss'
            },
        ],
        js: [
            {
                groupName: 'main',
                src: '../assets/scripts/**/*.js',
                dest: {path: '../assets/build/', fileName: 'main'},
                watch: '../assets/scripts/**/*.js'
            }
        ]
    }
);