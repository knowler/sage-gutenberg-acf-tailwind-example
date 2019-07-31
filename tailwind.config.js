const { typescale } = require('@knowler/typescale')

module.exports = {
  theme: {
    fontSize: typescale({
      ratio: 1.25,
      top: 8,
      bottom: -1,
    }),
    extend: {},
    container: {
      center: true,
      padding: '1rem',
    },
  },
  variants: {},
  plugins: [],
}
