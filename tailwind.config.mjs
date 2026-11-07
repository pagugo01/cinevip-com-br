/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],
  theme: {
    extend: {
      colors: {
        vip: {
          dark: '#030712',
          card: '#080d1a',
          gold: '#eab308',
          goldLight: '#fde047',
          amber: '#f59e0b',
          purple: '#8b5cf6',
          cyan: '#06b6d4'
        }
      },
      aspectRatio: {
        'poster': '2 / 3'
      }
    },
  },
  plugins: [],
};
