import { test, expect, describe } from 'vitest'
import { mount } from '@vue/test-utils'
import { Quasar } from 'quasar'

import QPassword from 'src/components/QPassword.vue'

const wrapperFactory = (args = {}) => mount(QPassword, {
  global: {
    plugins: [Quasar]
  },
  ...args
})

describe('QPassword component', () => {
  test('mount component', () => {
    expect(QPassword).toBeTruthy()
  })

  test('exists elements', () => {
    const wrapper = wrapperFactory()

    const input = wrapper.find('input')
    expect(input).toBeTruthy()

    const visibilityBtn = wrapper.find('i.q-icon')
    expect(visibilityBtn).toBeTruthy()
  })

  test('attributes binding', () => {
    const wrapper = wrapperFactory({ props: { label: 'my label' } })

    expect(wrapper.text()).toContain('my label')
  })

  test('emit model changes', async () => {
    const wrapper = wrapperFactory()
    const input = wrapper.find('input')

    await input.setValue('password')
    const emitted = wrapper.emitted()

    expect(emitted).toHaveProperty('update:modelValue')
    expect(emitted['update:modelValue'][0]).toEqual(['password'])
  })

  test('change visibility and see the password value', async () => {
    const wrapper = wrapperFactory()

    await wrapper.find('input').setValue('secret')

    expect(wrapper.find('input').element.type).toBe('password')
    expect(wrapper.find('i.q-icon').text()).toEqual('visibility')

    await wrapper.find('i.q-icon').trigger('click')

    expect(wrapper.find('input').element.type).toBe('text')
    expect(wrapper.find('i.q-icon').text()).toEqual('visibility_off')

    await wrapper.find('i.q-icon').trigger('click')

    expect(wrapper.find('input').element.type).toBe('password')
    expect(wrapper.find('i.q-icon').text()).toEqual('visibility')
  })
})
