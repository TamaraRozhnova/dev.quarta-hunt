module.exports = Object.freeze(
    {
        scss: [
            {
                groupName: 'main',
                src: '../assets/styles/main.scss',
                exclude: '../assets/styles/libs',
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
                src: '../assets/scripts/*.js',
                exclude: '../assets/scripts/main.js',
                dest: {path: '../assets/scripts/', fileName: 'main'},
                watch: '../assets/scripts/*.js'
            }
        ]
    }
);
