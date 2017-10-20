module.exports = function(grunt) {

  grunt.initConfig({
    sass: {
      options: {
        sourcemap: 'none',
        style: 'compressed'
      },
      dist: {
        files: {
          'style.css': 'style.scss'
        }
      }
    },
    watch: {
      files: 'style.scss',
      tasks: ['sass']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['sass']);
  grunt.registerTask('dev', ['sass', 'watch']);

};