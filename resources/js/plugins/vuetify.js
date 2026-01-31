import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

export default createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'dark', // Default to Dark mode for the "Hacker/Cool" vibe
    themes: {
      dark: {
        colors: {
          primary: '#6366f1', // Indigo
          secondary: '#a855f7', // Purple
          background: '#0f172a',
          surface: '#1e293b',
        }
      }
    }
  },
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: { mdi },
  },
})