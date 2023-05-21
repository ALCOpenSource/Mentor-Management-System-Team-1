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
        400: "#666666",
        300: "#808080",
        200: "#E6E6E6"
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
