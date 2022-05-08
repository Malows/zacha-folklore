<template>
  <q-layout view="hHh lpR lFr">
    <q-header
      reveal
      elevated
      class="bg-primary text-white"
    >
      <q-toolbar>
        <q-btn
          dense
          flat
          round
          icon="menu"
          @click="toggleDrawer"
        />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>
          {{ name }}
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="open"
      side="left"
      overlay
      bordered
    >
      <drawer-items />
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'

import DrawerItems from 'components/DrawerItems.vue'

const name = process.env.NAME

const open = ref(false)

const toggleDrawer = () => {
  open.value = !open.value
}
</script>
