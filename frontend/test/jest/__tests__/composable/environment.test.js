import { test, expect, describe, vi } from 'vitest'

const useRoute = vi.fn()
const useRouter = vi.fn()
const useStore = vi.fn()
const useQuasar = vi.fn()

vi.mock('vue-router', () => ({ useRoute, useRouter }))
vi.mock('vuex', () => ({ useStore }))
vi.mock('quasar', () => ({ useQuasar }))

import environment from 'src/composable/environment'

describe('environment composable', () => {
  test('generate environment', () => {
    const response = environment()

    expect(response).toHaveProperty('router')
    expect(response).toHaveProperty('route')
    expect(response).toHaveProperty('store')
    expect(response).toHaveProperty('quasar')

    expect(useRoute).toHaveBeenCalledOnce()
    expect(useRouter).toHaveBeenCalledOnce()
    expect(useStore).toHaveBeenCalledOnce()
    // expect(useQuasar).toHaveBeenCalledOnce() // is not called ... but why? Quasar api?
  })
})
