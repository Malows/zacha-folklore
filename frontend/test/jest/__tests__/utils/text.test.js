import { test, expect, describe, vi } from 'vitest'

import { capitalize, parsePrice, roleLabel } from 'src/utils/text'

describe('text utils - capitalize', () => {
  test('Capitalized word', () => {
    expect(capitalize('word')).toBe('Word')
    expect(capitalize('hello world')).toBe('Hello world')
  })
})

describe('text utils - parsePrice', () => {
  test('parsing a number to a price string', () => {
    expect(parsePrice(0.0)).toBe('$ 0,00') // special invisible character involved
    expect(parsePrice(10.0)).toBe('$ 10,00') // special invisible character involved
    expect(parsePrice(100)).toBe('$ 100,00') // special invisible character involved
  })
})

describe('text utils - roleLabel', () => {
  test('check values', () => {
    expect(roleLabel('admin')).toBe('Super admin')
    expect(roleLabel('manager')).toBe('Administrador')
    expect(roleLabel('ticket controller')).toBe('Control de entradas')
  })
})
