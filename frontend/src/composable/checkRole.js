import { computed } from 'vue'

function common (roleSet) {
  return (store, router, quasar) => {
    const roles = computed(() => store.state.session.user?.roles)

    if (!roles.value) {
      quasar.notify({
        message: 'Es necesario iniciar sesion para acceder a esta seccion.',
        type: 'accent',
        timeouts: 3500
      })

      return router.push({ name: 'login' })
    }

    const match = roles.value.some(r => roleSet.includes(r.name))

    if (!match) {
      quasar.notify({
        message: 'Permisos insuficientes para acceder a esta seccion',
        type: 'accent',
        timeouts: 3500
      })

      return router.push({ name: 'home' })
    }

    return null
  }
}

export const checkAdminRole = common(['admin'])
export const checkManagerRole = common(['manager', 'admin'])
export const checkTicketRole = common(['ticket controller', 'manager', 'admin'])
