/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./view/*.{php,html,js}"],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}