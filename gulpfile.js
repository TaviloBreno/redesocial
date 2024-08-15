const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const rename = require('gulp-rename');

// Caminhos para os arquivos SCSS e destino CSS
const paths = {
  scss: 'public/assets/scss/**/*.scss', // Caminho para os arquivos SCSS
  css: 'public/assets/css', // Caminho para o diretório de saída CSS
  fontAwesome: './node_modules/@fortawesome/fontawesome-free/webfonts/**/*', // Caminho para as fontes do Font Awesome
  fontsDest: 'public/assets/fonts' // Destino para as fontes do Font Awesome
};

// Tarefa para compilar, minimizar e renomear o CSS
function styles() {
  return gulp.src('public/assets/scss/main.scss') // Arquivo SCSS principal
    .pipe(sass().on('error', sass.logError)) // Compila SCSS para CSS
    .pipe(cleanCSS()) // Minimiza o CSS
    .pipe(rename('styles.min.css')) // Renomeia para styles.min.css
    .pipe(gulp.dest(paths.css)); // Salva o arquivo minimizado
}

// Tarefa para copiar fontes do Font Awesome
function fonts() {
  return gulp.src(paths.fontAwesome)
    .pipe(gulp.dest(paths.fontsDest));
}

// Tarefa padrão
exports.default = gulp.series(styles, fonts);

// Tarefa de observação
function watch() {
  gulp.watch(paths.scss, styles);
}

exports.watch = watch;
