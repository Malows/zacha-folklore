import { test, expect, describe, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import { Quasar } from 'quasar'

const push = vi.fn()
const dispatch = vi.fn()

vi.mock('vue-router', () => ({
  useRoute: vi.fn(),
  useRouter: vi.fn(() => ({ push }))
}))

vi.mock('vuex', () => ({
  useStore: vi.fn(() => ({ dispatch })),
}))


import DrawerItems from 'src/components/DrawerItems.vue'

const wrapperFactory = (args = {}) => mount(DrawerItems, {
  global: {
    plugins: [Quasar]
  },
  ...args
})

describe('DrawerItems component', () => {
  test('mount component', () => {
    expect(DrawerItems).toBeTruthy()
  })

  test('exists elements', () => {
    const wrapper = wrapperFactory()

    const items = wrapper.findAll('.q-item')

    expect(items).toHaveLength(6)

    expect(items[0].text()).toContain('home')
    expect(items[0].text()).toContain('Inicio')

    expect(items[1].text()).toContain('event')
    expect(items[1].text()).toContain('Eventos')

    expect(items[2].text()).toContain('menu_book')
    expect(items[2].text()).toContain('Menú')

    expect(items[3].text()).toContain('people')
    expect(items[3].text()).toContain('Reservas')

    expect(items[4].text()).toContain('person')
    expect(items[4].text()).toContain('Usuarios')

    expect(items[5].text()).toContain('logout')
    expect(items[5].text()).toContain('Cerrar sesión')

    expect(wrapper.find('.q-separator')).toBeTruthy()
  })

  test('click on logout routes', async () => {
    const wrapper = wrapperFactory()

    const items = wrapper.findAll('.q-item')

    expect(items).toHaveLength(6)

    await items[5].trigger('click')

    expect(push).toHaveBeenCalled()
    expect(push).toHaveBeenCalledWith({ name: 'login' })

    expect(dispatch).toHaveBeenCalled()
    expect(dispatch).toHaveBeenCalledWith('session/logout')
  })
})
