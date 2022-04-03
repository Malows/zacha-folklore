import {
  parse,
  parseJSON,
  format
} from 'date-fns'

const regionalDateFormat = 'dd/MM/yyyy'

/**
 *
 * @param {*} input
 * @returns
 */
export function toPlainString (input) {
  if (!input) {
    return ''
  }

  return format(parseJSON(input), regionalDateFormat)
}

/**
 *
 * @param {*} input
 * @returns
 */
export function fromPlainString (input) {
  if (!input) {
    return null
  }

  return parse(input, regionalDateFormat, new Date())
}

/**
 *
 * @param {*} input
 * @returns
 */
export function filterDate (input) {
  const dateFormat = /\d{2}.\d{2}.\d{4}/

  return dateFormat.exec(input)
    ? parse(input, regionalDateFormat, new Date())
    : null
}
