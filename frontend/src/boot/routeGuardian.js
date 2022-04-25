import { boot } from 'quasar/wrappers'
import isBefore from 'date-fns/isBefore'

function guardian (prefix) {
  return (to, _, next) => {
    if (!to.meta.requireAuth) return next()

    if (!checkLocalAuth(prefix)) return next({ path: '/login' })

    return next()
  }
}

export const checkLocalAuth = (prefix) => {
  const authToken = localStorage.getItem(`${prefix}_access_token`)
  if (!authToken) {
    localStorage.clear()
    return false
  }

  const expireSession = new Date((localStorage.getItem(`${prefix}_expiration_at`)))
  if (!expireSession) return false

  return isBefore(Date.now(), expireSession)
}

export default boot(({ router }) => {
  router.beforeEach(guardian(process.env.STORAGE_PREFIX))
})
