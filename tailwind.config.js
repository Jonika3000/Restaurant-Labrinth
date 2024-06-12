/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
      xxl: '1536px',
    },
    spacing: {
      '1': '4px',
      '2': '8px',
      '3': '12px',
      '4': '16px',
      '5': '20px',
      '6': '24px',
      '7': '32px',
      '8': '48px'
    },
    colors: {
      transparent: 'transparent',
      'background': '#202632',
      'purple': '#7e5bef',
      'black': '#000000',
      'orange': '#ff7849',
      'green': '#388883',
      'light-blue': '#E0F1FF',
      'white': '#ffffff',
      'gray': {
        100: '#d3dce6',
        200: '#404153',
        300: '#655D75',
        400: '#4D5360'
      },
      'text': '#F2F9FF',
      'yellow': '#DAA21B'
    },
    fontFamily: {
      sans: ['Work Sans', 'sans-serif']
    },
    extend: {
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      borderRadius: {
        '4xl': '2rem',
      }
    }
  },
  plugins: [],
}
