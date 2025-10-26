import defaultTheme from 'tailwindcss/defaultTheme'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/js/**/*.vue'
  ],
    plugins: [
        require('@tailwindcss/typography')
  ],
  theme: {
    extend: {
      animation: {
        'pulse-1s': 'pulse 1s ease-in-out'
      },
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
};



/*module.exports = {
  theme: {
    extend: {
      fontSize: {
        h1: "clamp(31px, 5vw, 49px)",
        h2: "clamp(25px, 4.2vw, 39px)",
        h3: "clamp(20px, 3.5vw, 31px)",
        h4: "clamp(18px, 3vw, 25px)",
        h5: "clamp(16px, 2.6vw, 20px)",
        h6: "clamp(15px, 2.3vw, 18px)",
        body: "clamp(14px, 1.9vw, 16px)",
        link: "clamp(13px, 1.8vw, 15px)",
        caption: "clamp(12px, 1.6vw, 14px)",
      },
    },
  },
};*/