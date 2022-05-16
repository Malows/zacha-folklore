/**
 *
 * @param {*} param0
 * @returns
 */
export default function ({ singular, collection }) {
  const idName = `${singular}Id`

  return {
    [singular]: function (state, _, { route }) {
      const { params } = route

      if (!Object.prototype.hasOwnProperty.call(params, idName)) return null

      const elements = state[collection]

      return elements.find(x => x.id === parseInt(params[idName]))
    }
  }
}

/**
 *
 * @param {*} initialSetup
 * @param {*} param1
 * @param {*} mapper
 * @returns
 */
export function optionsMapper (
  initialSetup,
  { name = '', collection = '' },
  mapper = (x) => ({ value: x.id, label: x.name })
) {
  const key = name || `${collection}Options`

  initialSetup[key] = (state) => state[collection].map(mapper)

  return initialSetup
}
