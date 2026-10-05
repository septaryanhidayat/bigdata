/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        "primary": "#004532",
        "primary-container": "#065f46",
        "secondary-container": "#fd761a",
        "accent-orange": "#f97316",
        "on-surface": "#0f172a",
        "on-surface-variant": "#475569",
        "background": "#f8fafc",
        "surface": "#ffffff",
        "outline-variant": "#e2e8f0"
      },
      spacing: {
        "md": "16px",
        "sm": "8px",
        "xs": "4px",
        "lg": "24px",
        "xl": "48px",
        "container-max": "1280px",
        "gutter": "20px"
      },
      fontFamily: {
        "body": ["Inter", "sans-serif"],
        "headline": ["Montserrat", "sans-serif"]
      },
      borderRadius: {
        "DEFAULT": "0.25rem",
        "lg": "0.5rem",
        "xl": "0.75rem",
        "full": "9999px"
      },
      boxShadow: {
        "xs": "0 1px 2px 0 rgb(0 0 0 / 0.05)",
        "md": "0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)",
        "card": "0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)"
      }
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/container-queries')
  ]
};
