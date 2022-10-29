import genericAction, { transitiveGenericActions } from './actions'
import genericMutations from './mutations'
import genericGetters from './getters'

export default function ({ singular, plural, collection, namespace = true, service, state }) {
  return {
    namespaced: true,
    getters: genericGetters({ singular, collection }),
    mutations: genericMutations({ singular, plural, collection }),
    actions: genericAction({ singular, plural, namespace, service }),
    state
  }
}

export function transitiveGenericModule ({ singular, plural, collection, namespace = true, service, state }) {
  return {
    namespaced: true,
    getters: genericGetters({ singular, collection }),
    mutations: genericMutations({ singular, plural, collection }),
    actions: transitiveGenericActions({ singular, plural, namespace, service }),
    state
  }
}
