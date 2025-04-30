/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["../../src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        primary: {
          800: "#1f2937", //backgorund or white
          700: "#0f4c81", //active
          600: "#164c70", //text
          500: "#336699", //hover
        },
        secondary: {
          800: "#B2FFFC",
          700: "#C7B8EA",
          600: "#6A5ACD",
          700: "#E5E5EA",
        },
        accent: {},
        muted: {},
        danger: {
          800: "#991B1B",
          700: "#B91C1C",
          600: "#DC2626",
          500: "#EF4444",
        },
      },
    },
  },
  plugins: [],
};
