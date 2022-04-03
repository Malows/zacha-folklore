import { capitalize } from 'src/utils/text'

export default function ({ plural, singular, collection }) {
  singular = capitalize(singular)
  plural = capitalize(plural)

  return {
    [`set${plural}`]: function (state, payload) {
      state[collection] = payload
    },

    [`set${singular}`]: function (state, payload) {
      const index = state[collection].findIndex((x) => x.id === payload.id)

      if (index !== -1) {
        state[collection] = [
          ...state[collection].slice(0, index),
          payload,
          ...state[collection].slice(index + 1)
        ]
      } else {
        state[collection] = [...state[collection], payload]
      }
    },

    [`add${singular}`]: function (state, payload) {
      state[collection] = [...state[collection], payload]
    },

    [`remove${singular}`]: function (state, payload) {
      const index = state[collection].findIndex((x) => x.id === payload.id)

      if (index !== -1) {
        state[collection] = [
          ...state[collection].slice(0, index),
          ...state[collection].slice(index + 1)
        ]
      }
    }
  }
}
