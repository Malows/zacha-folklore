import { capitalize } from 'src/utils/text'

/**
 * Store actions for handle common crud queries
 *
 * @param {ActionsInterface} param0
 *
 * @returns {Object}
 */
export default function genericActions ({ plural, singular, namespace = true, service }) {
  plural = capitalize(plural)
  singular = capitalize(singular)

  const auxiliaryPlural = namespace ? plural : ''
  const auxiliarySingular = namespace ? singular : ''

  const fetchAction = `fetch${auxiliaryPlural}`
  const getAction = `get${auxiliarySingular}`
  const createAction = `create${auxiliarySingular}`
  const updateAction = `update${auxiliarySingular}`
  const removeAction = `remove${auxiliarySingular}`

  return {
    async [fetchAction] ({ commit }) {
      const response = await service.fetch()

      if (response.isOk) {
        commit(`set${plural}`, response.data)
      }

      return response
    },

    async [getAction] ({ commit }, id) {
      const payload = typeof id === 'object'
        ? id
        : { id }

      const response = await service.get(payload)

      if (response.isOk) {
        commit(`set${singular}`, response.data)
      }
      return response
    },

    async [createAction] ({ commit }, payload) {
      const response = await service.create(payload)

      if (response.isOk) {
        commit(`add${singular}`, response.data)
      }
      return response
    },

    async [updateAction] ({ commit }, payload) {
      const response = await service.update(payload)

      if (response.isOk) {
        commit(`set${singular}`, response.data)
      }

      return response
    },

    async [removeAction] ({ commit }, payload) {
      const response = await service.remove(payload)

      if (response.isOk) {
        commit(`remove${singular}`, response.data)
      }

      return response
    }
  }
}

/**
 * Store actions for handle transitive crud queries
 *
 * @param {ActionsInterface} param0
 *
 * @returns {Object}
 */
export function transitiveGenericActions ({ plural, singular, namespace = true, service }) {
  plural = capitalize(plural)
  const auxiliaryPlural = namespace ? plural : ''
  const fetchAction = `fetch${auxiliaryPlural}`

  const data = genericActions({ plural, singular, namespace, service })

  data[fetchAction] = async function ({ commit }, payload) {
    const response = await service.fetch(payload)

    if (response.isOk) {
      commit(`set${plural}`, response.data)
    }

    return response
  }

  return data
}
