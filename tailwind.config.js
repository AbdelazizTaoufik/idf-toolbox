const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'media',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Nunito', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        brand: {
          50: '#fceeee',
          100: '#f7dbd9',
          200: '#edb8b6',
          300: '#df8c86',
          400: '#cd5951',
          500: '#b53930',
          600: '#972d26',
          700: '#78221c',
          800: '#5a1b16',
          900: '#3f1512',
          950: '#260e0d',
        },
      },
      boxShadow: {
        warm: '0 10px 30px -12px rgba(38, 14, 13, 0.25)',
        'warm-lg': '0 25px 50px -12px rgba(38, 14, 13, 0.3)',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
