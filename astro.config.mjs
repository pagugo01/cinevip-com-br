import { defineConfig } from 'astro/config';
import tailwind from '@astrojs/tailwind';

export default defineConfig({
  site: 'https://cinevip.com.br',
  output: 'static',
  integrations: [tailwind({
    applyBaseStyles: true
  })],
  compressHTML: true,
  build: {
    format: 'directory'
  }
});
