/**
 *
 * @param {*} object
 * @param {*} keys
 * @returns
 */
function only (object, keys) {
  return keys.map(x => (object[x]).toLowerCase())
}

/**
 *
 * @param {*} searchInput
 * @param {*} searchFields
 * @returns
 */
function compare (searchInput, searchFields) {
  const toSearch = searchInput.toLowerCase()

  return (x) => {
    return only(x, searchFields).some(value => value?.includes(toSearch))
  }
}

/**
 *
 * @param {*} searchField
 * @returns
 */
export function byName (searchField) {
  return compare(searchField, ['name'])
}
