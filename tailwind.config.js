/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial'],
      },
      colors: {
        brand: {
          50:  '#eef4ff',
          100: '#dbe7ff',
          200: '#b7ceff',
          300: '#8fb2ff',
          400: '#6a95ff',
          500: '#4a73ff', // principal
          600: '#3559db',
          700: '#2a46ad',
          800: '#203681',
          900: '#1a2b66',
        },
        accent: {
          50:  '#fff7ed',
          100: '#ffedd5',
          200: '#fed7aa',
          300: '#fdba74',
          400: '#fb923c',
          500: '#f97316',
          600: '#ea580c',
          700: '#c2410c',
          800: '#9a3412',
          900: '#7c2d12',
        },
        success: { 500: '#16a34a' },
        warning: { 500: '#eab308' },
        danger:  { 500: '#ef4444' },
      },
      boxShadow: {
        soft: '0 8px 24px rgba(0,0,0,0.08)',
      },
      container: {
        center: true,
        padding: '1rem',
        screens: {
          lg: '1024px',
          xl: '1200px',
          '2xl': '1320px',
        },
      },
    },
  },
  plugins: [],
}
