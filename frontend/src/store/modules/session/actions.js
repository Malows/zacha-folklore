import isPast from 'date-fns/isPast'
import parseISO from 'date-fns/parseISO'
import SessionService from 'src/services/SessionService'
import utils from './utils'

export default function (context) {
  const service = new SessionService(context)
  const { getValues, parseValuesFromResponse } = utils(context)

  return {
    async login ({ commit, dispatch }, payload) {
      const response = await service.login(payload)

      if (response.isOk) {
        commit('login', parseValuesFromResponse(response))

        await dispatch('fetchUserData')
      }

      return response
    },

    async logout ({ commit }) {
      commit('logout')
    },

    async checkSession ({ commit, dispatch }) {
      const values = getValues()
      const { loginAt, expirationAt, accessToken } = values

      const areInvalid = !(loginAt && expirationAt && accessToken)
      if (areInvalid || isPast(parseISO(expirationAt))) {
        return false
      }

      commit('login', values)

      const response = await dispatch('fetchUserData')

      return response
    },

    async fetchUserData ({ commit }) {
      const response = await service.fetchUserData()

      if (response.isOk) {
        commit('setUserData', response.data)
      }
      return response
    }
  }
}
