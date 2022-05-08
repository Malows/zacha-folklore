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
const items = [
  { icon: 'event', text: 'Evento', to: { name: 'events index' } },
  { icon: 'people', text: 'Reservas', to: { name: 'reservations index' } },
  { icon: 'person', text: 'Usuarios', to: { name: 'users index' } }
]

const logout = () => {}
</script>
