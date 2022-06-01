import { Notify, Platform } from 'quasar'

Notify.setDefaults({
  position: Platform.is.desktop ? 'bottom-right' : 'bottom',
  color: 'positive',
  timeout: 2500,
  textColor: 'white',
  actions: [{ icon: 'close', color: 'white' }]
})
