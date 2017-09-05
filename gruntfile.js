module.exports = function(grunt) {

  grunt.initConfig({
    sass: {
      options: {
        sourcemap: 'none'
      },
      dist: {
        files: {
          'style.css': 'src/sass/style.scss'
        }
      }
    },
    watch: {
      files: 'src/sass/style.scss',
      tasks: ['sass']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['sass']);
  grunt.registerTask('dev', ['sass', 'watch']);

};