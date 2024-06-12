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
    colors: {
      transparent: 'transparent',
      'background': '#202632',
      'purple': '#7e5bef',
      'black': '#000000',
      'orange': '#ff7849',
      'green': '#388883',
      'lightBlue': '#E0F1FF',
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
      sans: ['Work Sans', 'sans-serif'],
      gwendolyn: ['Gwendolyn', 'cursive']
    },
    extend: {
      textDecoration: ['hover', 'focus'],
      inset: {
        '0': '0',
        auto: 'auto',
        '1/2': '50%',
        'full': '100%',
        '10': '10px',
        '20': '20px',
        '40': '40px',
        '50': '50px',
      },
      gap: {
        '10': '10px',
        '20': '20px',
      },
    }
  },
  plugins: [],
}
