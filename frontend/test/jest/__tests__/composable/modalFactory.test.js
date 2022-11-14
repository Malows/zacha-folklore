import { test, expect, describe } from 'vitest'

import modalFactory from 'src/composable/modalFactory'

describe('modalFactory composable', () => {
  test('open a modal', () => {
    const [modal, openModal] = modalFactory()

    expect(modal.value).toBe(false)

    openModal()

    expect(modal.value).toBe(true)
  })
})
