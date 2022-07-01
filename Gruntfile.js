module.exports = function(grunt) {
 
  grunt.initConfig({

    asset_dev_path       : 'resources/assets/',
    asset_dist_path      : 'public/css/',

    sass: {
      dist: {
        options: {
          style: 'expanded'
        },
        files: {
          '<%= asset_dev_path %>/dev-style.css': '<%= asset_dev_path %>/sass/build.scss'
        }
      }
    },

    autoprefixer: {
      options: {
        browsers: [
          'last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'
        ]
      },
      dist: {
        src: '<%= asset_dev_path %>/dev-style.css'
      }
    },    

    cssmin: {
      options: {
        keepSpecialComments:0
      },
      dist: {
        files: {
          '<%= asset_dist_path %>/style.css': '<%= asset_dev_path %>/dev-style.css'
        }
      }
    }, 

    watch: {
      styles: {
        files: '<%= asset_dev_path %>sass/**/*.scss',
        tasks: ['sass', 'autoprefixer', 'cssmin']
      }     
    },

  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  grunt.registerTask('default', [
    'sass',
    'autoprefixer',
    'cssmin'
  ]);
};