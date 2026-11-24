/* Konfigurasi warna merah untuk semua utility brand yang digunakan HTML. */
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif']
      },
      colors: {
        brand: {
          50: '#fff5f5',
          100: '#fee2e2',
          200: '#fecaca',
          300: '#fca5a5',
          400: '#f87171',
          500: '#ef4444',
          600: '#dc2626',
          700: '#b42335',
          800: '#991b2f',
          900: '#801b2a',
          950: '#57121d'
        }
      }
    }
  }
};
