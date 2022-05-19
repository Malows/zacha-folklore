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
import environment from 'src/composable/environment'

const items = [
  // { icon: 'event', text: 'Evento', to: { name: 'events index' } },
  { icon: 'menu_book', text: 'Menu', to: { name: 'menu index' } },
  { icon: 'people', text: 'Reservas', to: { name: 'reservations index' } },
  { icon: 'person', text: 'Usuarios', to: { name: 'users index' } }
]

const { router, store } = environment()

const logout = () => {
  store.dispatch('session/logout')
  router.push({ name: 'login' })
}
</script>
