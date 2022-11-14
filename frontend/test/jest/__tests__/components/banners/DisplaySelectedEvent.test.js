import { test, expect, describe } from 'vitest'
import { mount } from '@vue/test-utils'
import { Quasar } from 'quasar'

import DisplaySelectedEvent from 'src/components/banners/DisplaySelectedEvent.vue'

const wrapperFactory = (args = {}) => mount(DisplaySelectedEvent, {
  global: {
    plugins: [Quasar]
  },
  ...args
})

describe('DisplaySelectedEvent component', () => {
  test('mount component', () => {
    expect(DisplaySelectedEvent).toBeTruthy()
  })

  test('exists element', () => {
    const wrapper = wrapperFactory({ props: { event: { name: 'test event' } } })

    expect(wrapper.text()).toContain('test event es el evento seleccionado para trabajar.')

    expect(wrapper.find('button')).toBeTruthy()
    expect(wrapper.find('button').text()).toBe('Seleccionar otro')
  })

  test('check visibility', () => {
    const wrapper = wrapperFactory({ props: {} })
    expect(wrapper.text()).toBeFalsy()
  })
})
