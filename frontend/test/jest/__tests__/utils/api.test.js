import { test, expect, describe } from 'vitest'

import { toPlainString, fromPlainString, toInput, fromInput, filterDate } from 'src/utils/date'

describe('date utils - toPlainString', () => {
  test('if the input is falsy the value is empty string', () => {
    expect(toPlainString('')).toBe('')
    expect(toPlainString(null)).toBe('')
  })

  test('happy path on a json formated date', () => {
    expect(toPlainString('1970-01-01T23:59:59Z')).toBe('01/01/1970')
  })

  test('happy path on a date object', () => {
    expect(toPlainString(new Date(1970, 0, 1))).toBe('01/01/1970')
  })
})

describe('date utils - fromPlainString', () => {
  test('if the input is falsy the value is null', () => {
    expect(fromPlainString('')).toBe(null)
    expect(fromPlainString(null)).toBe(null)
  })

  test('happy path', () => {
    expect(fromPlainString('01/01/1970').toJSON()).toBe(new Date(1970, 0, 1).toJSON())
  })
})

describe('date utils - toInput', () => {
//   test('if the input is falsy the value is empty string', () => {
//     expect(toInput('')).toThrow('Invalid time value')
//     expect(toInput(null)).toThrow('Invalid time value')
//   })

  test('happy path on a date object', () => {
    expect(toInput(new Date(1970, 0, 1))).toBe('1970/01/01')
  })
})

describe('date utils - fromInput', () => {
  test('if the input is falsy the value is null', () => {
    expect(fromInput('')).toBe(null)
    expect(fromInput(null)).toBe(null)
  })

  test('happy path', () => {
    expect(fromInput('1970/01/01').toJSON()).toBe(new Date(1970, 0, 1).toJSON())
  })
})

describe('date utils - filterDate', () => {
  test('matching date should return a date object', () => {
    expect(filterDate('01/01/1970').toJSON()).toBe(new Date(1970, 0, 1).toJSON())
  })

  test('not matching dates should return null', () => {
    expect(filterDate('-')).toBe(null)
  })
})
