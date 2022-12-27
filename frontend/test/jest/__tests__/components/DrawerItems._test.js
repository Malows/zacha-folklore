import { test, expect, describe, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import { Quasar } from 'quasar'
import DrawerItems from 'src/components/DrawerItems.vue'

vi.resetAllMocks()

const push = vi.fn()
const dispatch = vi.fn()

vi.mock('vue-router', () => ({
  useRoute: vi.fn(),
  useRouter: vi.fn(() => ({ push }))
}))

vi.mock('vuex', () => ({
  useStore: vi.fn(() => ({
    dispatch,
    state: { session: { user: { roles: ['admin'] } } }
  }))
}))

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

  test('check permissions to manager', () => {
    vi.doMock('vuex', () => ({
      useStore: vi.fn(() => ({
        dispatch,
        state: { session: { user: { roles: ['manager'] } } }
      }))
    }))

    const wrapper = wrapperFactory()

    const items = wrapper.findAll('.q-item')

    expect(items).toHaveLength(5)

    expect(items[0].text()).toContain('home')
    expect(items[0].text()).toContain('Inicio')

    expect(items[1].text()).toContain('event')
    expect(items[1].text()).toContain('Eventos')

    expect(items[2].text()).toContain('menu_book')
    expect(items[2].text()).toContain('Menú')

    expect(items[3].text()).toContain('people')
    expect(items[3].text()).toContain('Reservas')

    expect(items[4].text()).toContain('logout')
    expect(items[4].text()).toContain('Cerrar sesión')
  })

  test('check permissions to ticket controller', () => {
    vi.doMock('vuex', () => ({
      useStore: vi.fn(() => ({
        dispatch,
        state: { session: { user: { roles: ['ticket controller'] } } }
      }))
    }))

    const wrapper = wrapperFactory()

    const items = wrapper.findAll('.q-item')

    expect(items).toHaveLength(2)

    expect(items[0].text()).toContain('home')
    expect(items[0].text()).toContain('Inicio')

    expect(items[1].text()).toContain('logout')
    expect(items[1].text()).toContain('Cerrar sesión')
  })
})
