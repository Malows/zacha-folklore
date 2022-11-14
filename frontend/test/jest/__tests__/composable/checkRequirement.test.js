import { test, expect, describe, vi } from 'vitest'

import { checkEvent } from 'src/composable/checkRequirement'

describe('checkRequirement composable - checkEvent', () => {
  const notify = vi.fn()
  const quasar = { notify }

  const push = vi.fn()
  const router = { push }

  const storeWith = {
    state: {
      events: {
        selectedEvent: { id: 1 }
      }
    }
  }

  const storeWithout = {
    state: {
      events: {
        selectedEvent: null
      }
    }
  }

  test('if has event return event id', () => {
    const response = checkEvent(storeWith, router, quasar)

    expect(response).toBe(1)
    expect(notify).not.toHaveBeenCalled()
    expect(push).not.toHaveBeenCalled()
  })

  test('if hasnt event push to route', () => {
    const response = checkEvent(storeWithout, router, quasar)

    expect(response).toBe(null)
    expect(notify).toHaveBeenCalled()
    expect(push).toHaveBeenCalled()
    expect(push).toHaveBeenCalledWith({ name: 'events selection' })
  })
})
