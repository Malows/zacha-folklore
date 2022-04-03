import { store } from 'quasar/wrappers'
import { createStore } from 'vuex'
import persistedState from 'vuex-persistedstate'
import makeSessionModule from 'laravel-passport-session-store'

import users from './users'

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

const session = makeSessionModule({
  prefix: process.env.STORAGE_PREFIX,
  clientSecret: process.env.CLIENT_SECRET,
  clientID: process.env.CLIENT_ID,
  url: process.env.HOST
})

export default store(function (/* { ssrContext } */) {
  const Store = createStore({
    plugins: [
      persistedState({
        key: process.env.STORAGE_PREFIX
      })
    ],

    modules: {
      session,
      users
    },

    // enable strict mode (adds overhead!)
    // for dev mode and --debug builds only
    strict: process.env.DEBUGGING
  })

  return Store
})
