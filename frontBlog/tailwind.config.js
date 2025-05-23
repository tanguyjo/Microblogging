/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      fontFamily: {
        sans: "var(--font-sans)",
        title: "var(--font-title)",
      },
      colors: {
        violet: "#B583FF", // violet
        darkviolet: "#9149FF", // violet foncé
      },
    },
  },
  plugins: [],
};
