import { computed } from 'vue'

function common (message, timeouts, getter, routeName) {
  return (store, router, quasar) => {
    const element = computed(() => getter(store))

    if (!element.value) {
      quasar.notify({
        message,
        type: 'accent',
        timeouts
      })

      router.push({ name: routeName })

      return null
    }

    return element.value.id
  }
}

export const checkEvent = common(
  'Debes elegir un evento primero.',
  5000,
  (store) => store.state.events.selectedEvent,
  'events selection'
)
