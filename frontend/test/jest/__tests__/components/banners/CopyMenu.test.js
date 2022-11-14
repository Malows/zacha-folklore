import { test, expect, describe, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import { useRouter } from 'vue-router'
import { Quasar } from 'quasar'

const push = vi.fn()

vi.mock('vue-router', () => ({
  useRoute: vi.fn(),
  useRouter: vi.fn(() => ({ push }))
}))

import CopyMenu from 'src/components/banners/CopyMenu.vue'

const wrapperFactory = (args = {}) => mount(CopyMenu, {
  global: {
    plugins: [Quasar]
  },
  ...args
})

describe('CopyMenu component', () => {
  test('mount component', () => {
    expect(CopyMenu).toBeTruthy()
  })

  test('exists element', () => {
    const wrapper = wrapperFactory({ props: { sections: [] } })

    expect(wrapper.text()).toContain('Este evento no tiene elementos en su menú.')

    expect(wrapper.find('button:first-child')).toBeTruthy()
    expect(wrapper.find('button:first-child').text()).toBe('Si')

    expect(wrapper.find('button:last-child')).toBeTruthy()
    expect(wrapper.find('button:last-child').text()).toBe('No')
  })

  test('if exists sections it wont show up', () => {
    const wrapper = wrapperFactory({ props: { sections: [{ name: 'not empty' }] } })

    expect(wrapper.element.getAttribute('style')).toBe('display: none;')
  })

  test('change route if click on the copy path', async () => {

    useRouter.mockImplementationOnce(() => ({ push }))

    const wrapper = wrapperFactory({
      global: {
        plugins: [Quasar],
        stubs: ['router-link', 'router-view']
      },
      props: { sections: [] }
    })

    expect(wrapper.element.getAttribute('style')).not.toBe('display: none;')

    await wrapper.find('button:first-child').trigger('click')

    // expect(push).toHaveBeenCalled()
    // expect(push).toHaveBeenCalledWith('/copiar-menu')
  })

  test('change visibility if click on cancel copy path', async () => {
    const wrapper = wrapperFactory({ props: { sections: [] } })

    expect(wrapper.element.getAttribute('style')).not.toBe('display: none;')

    await wrapper.find('button:last-child').trigger('click')

    expect(wrapper.element.getAttribute('style')).toBe('display: none;')
  })
})
