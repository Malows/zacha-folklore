import {
  parse,
  parseJSON,
  format
} from 'date-fns'

const regionalDateFormat = 'dd/MM/yyyy'
const inputFormat = 'yyyy/MM/dd'

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
export function toInput (input) {
  return format(input, inputFormat)
}

/**
 *
 * @param {*} input
 * @returns
 */
export function fromInput (input) {
  if (!input) {
    return null
  }

  return parse(input, inputFormat, new Date())
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
