import { test, expect, describe } from 'vitest'

import { byName, reservationFilter } from 'src/utils/filters'

describe('filters utils - byName', () => {
  const data = [{'name': 'foo'},{'name': 'bar'}]

  test('empty input', () => {
    expect(data.filter(byName(''))).lengthOf(2)
  })

  test('valid input', () => {
    const filtered = data.filter(byName('a'))
    expect(filtered).lengthOf(1)
    expect(filtered[0]).toEqual({'name': 'bar'})
  })
})

describe('filters utils - reservationFilter', () => {
  const data = [
    {name: 'foo', lastName: 'ree', amount: 12},
    {name: 'bar', lastName: 'koz', amount: 31}
  ]

  test('empty input', () => {
    expect(data.filter(reservationFilter(''))).lengthOf(2)
  })

  test('valid input name', () => {
    const filtered = data.filter(reservationFilter('a'))
    expect(filtered).lengthOf(1)
    expect(filtered[0]).toEqual(data[1])
  })

  test('empty input lastName', () => {
    const filtered = data.filter(reservationFilter('ee'))
    expect(filtered).lengthOf(1)
    expect(filtered[0]).toEqual(data[0])
  })

  test('valid input amount', () => {
    const filtered = data.filter(reservationFilter('2'))
    expect(filtered).lengthOf(1)
    expect(filtered[0]).toEqual(data[0])
  })

  test('valid input mixed', () => {
    const filtered = data.filter(reservationFilter('r'))
    expect(filtered).lengthOf(2)
  })
})
