<template>
  <page-with-actions
    v-if="event"
    title="Ver Evento"
  >
    <template #actions>
      <action-btn
        label="Editar"
        icon="edit"
        :to="editRoute"
      />
      <action-btn
        label="Eliminar"
        icon="delete"
        color="negative"
        @click="showModalDelete"
      />
    </template>

    <inline-data label="Nombre">
      {{ event.name }}
    </inline-data>

    <inline-data label="Dia del evento">
      {{ event.eventDay }}
    </inline-data>

    <inline-data label="Hora de inicio">
      {{ event.startedAt }}
    </inline-data>

    <inline-data label="Evento activo">
      <q-icon
        size="md"
        :name="icon.type"
        :color="icon.color"
      />
    </inline-data>

    <inline-data label="Direccion">
      {{ event.address }}
    </inline-data>

    <inline-data label="Ubicacion">
      {{ event.location }}
    </inline-data>

    <q-dialog v-model="modalDelete">
      <delete-dialog :event="event" />
    </q-dialog>
  </page-with-actions>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import modalFactory from 'src/composable/modalFactory'
import environment from 'src/composable/environment'
import { pull } from 'src/utils/api'

import PageWithActions from 'components/shared/pages/PageWithActions.vue'
import ActionBtn from 'src/components/shared/stickyButtons/ActionBtn.vue'
import InlineData from 'components/shared/InlineData.vue'
import DeleteDialog from 'components/dialogs/events/DeleteDialog.vue'

const { store, quasar, route } = environment()

const event = computed(() => store.getters['events/event'])
const icon = computed(() => event.value?.isActive ? { type: 'check', color: 'positive' } : { type: 'close', color: 'negative' })

const [modalDelete, showModalDelete] = modalFactory()

const editRoute = computed(() => ({
  name: 'events edit',
  params: { eventId: event.value?.id ?? '' }
}))

onMounted(async () => {
  if (!event.value) {
    await pull(store, quasar, 'events/get', route.params.eventId)
  }
})

</script>
