import { store } from 'quasar/wrappers'
import { createStore } from 'vuex'
import persistedState from 'vuex-persistedstate'

import events from './modules/events'
import menuItems from './modules/menuItems'
import menuSections from './modules/menuSections'
import reservations from './modules/reservations'
import users from './modules/users'
import session from './modules/session'

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default store(function (/* { ssrContext } */) {
  const Store = createStore({
    plugins: [
      persistedState({
        key: process.env.STORAGE_PREFIX
      })
    ],

    modules: {
      events,
      menuItems,
      menuSections,
      reservations,
      session,
      users
    },

    // enable strict mode (adds overhead!)
    // for dev mode and --debug builds only
    strict: process.env.DEBUGGING
  })

  return Store
})
