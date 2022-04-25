import state from './state'
import mutations from './mutations'
import actions from './actions'

const context = {
  prefix: process.env.STORAGE_PREFIX,
  url: process.env.HOST || 'localhost:8000',
  clientSecret: process.env.CLIENT_SECRET,
  clientID: process.env.CLIENT_ID,
  profileURI: '/api/user',
  oauthURI: '/oauth/token'
}

export default {
  namespaced: true,
  state,
  mutations: mutations(context),
  actions: actions(context)
}
