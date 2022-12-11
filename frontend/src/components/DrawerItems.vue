<template>
  <q-list>
    <q-item
      v-for="item in items"
      :key="item.text"
      :to="item.to"
      exact
    >
      <q-item-section avatar>
        <q-icon :name="item.icon" />
      </q-item-section>
      <q-item-section>
        {{ item.text }}
      </q-item-section>
    </q-item>

    <q-separator />

    <q-item
      clickable
      @click="logout"
    >
      <q-item-section avatar>
        <q-icon name="logout" />
      </q-item-section>
      <q-item-section>
        Cerrar sesión
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script setup>
import { computed } from 'vue'
import environment from '../composable/environment'

const privateItems = [
  { icon: 'home', text: 'Inicio', to: { name: 'home' } },
  { icon: 'event', text: 'Eventos', to: { name: 'events index' } },
  { icon: 'menu_book', text: 'Menú', to: { name: 'menu index' } },
  { icon: 'people', text: 'Reservas', to: { name: 'reservations index' } },
  { icon: 'person', text: 'Usuarios', to: { name: 'users index' } }
]

const { router, store } = environment()

const items = computed(() => {
  const roles = store.state.session.user?.roles

  if (!roles) return []

  if (roles.some(r => r.name === 'admin')) {
    return privateItems
  }

  if (roles.some(r => r.name === 'manager')) {
    return privateItems.slice(0, -1)
  }

  return [privateItems[0]]
})

const logout = () => {
  store.dispatch('session/logout')
  router.push({ name: 'login' })
}
</script>
