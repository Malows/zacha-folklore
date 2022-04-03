import { boot } from 'quasar/wrappers'
import { sync } from 'vuex-router-sync'

export default boot(async ({ router, store }) => {
  sync(store, router)

  const pass = await store.dispatch('session/checkSession')

  if (!pass) {
    void router.push('/login')
  }
})
