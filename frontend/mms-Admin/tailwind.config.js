/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    colors: {
      green: {
        100: "#F7FEFF",
        200: '#E6FDFE',
        400: "#058B94"
      },
      gray: {
        300: "#808080"
      },
      red: {
        400: "#CC000E"
      },
      black: {
        400: "#333333"
      }
    },
    extend: {},
  },
  plugins: [],
};
