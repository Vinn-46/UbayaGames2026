import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
          ug: {
            light: "#CBDCC1",
            base: "#9E9B8C",
            gray: "#6B7068",
            brown: "#473A36",
            dark: "#1B2023",
          }
        },
        fontFamily: {
            heading: ['GameofThrones', 'serif'], 
            body: ['Georgia', 'serif'],
        },
      },
    },
    plugins: [],
}