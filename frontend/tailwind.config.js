/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ["class"],

  theme: {
    fontFamily: {
      Poppins: ["Poppins"],
    },

    container: {
      center: true,
      padding: "0.75rem",
      screens: {
        "2xl": "1400px",
      },
    },
  },
  plugins: [require("tailwindcss-animate")],
};
