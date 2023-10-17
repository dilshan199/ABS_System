/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/***/*.blade.php",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {},
    colors: {
        'white': '#FFFFFF',
        'navy-blue': {
            DEFAULT: '#000066',
            50: '#1F1FFF',
            100: '#0A0AFF',
            200: '#0000E0',
            300: '#0000B8',
            400: '#00008F',
            500: '#000066',
            600: '#00002E',
            700: '#000000',
            800: '#000000',
            900: '#000000',
            950: '#000000'
        },
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('@tailwindcss/forms'),
  ],
}

