<template>
  <page-with-actions
    v-if="reservation"
    title="Ver Reserva"
  >
    <template #actions>
      <action
        label="Editar"
        icon="edit"
        :to="editRoute"
      />
      <action
        label="Eliminar"
        icon="delete"
        color="negative"
        @click="showModalDelete"
      />
    </template>

    <inline-data label="Nombre">
      {{ reservation.name }}
    </inline-data>

    <inline-data label="Apellido">
      {{ reservation.lastName }}
    </inline-data>

    <inline-data label="Cantidad">
      {{ reservation.amount }}
    </inline-data>

    <inline-data label="Email">
      {{ reservation.email }}
    </inline-data>

    <inline-data label="Teléfono">
      {{ reservation.phone }}
    </inline-data>

    <q-separator />
    <inline-data label="Pagada">
      <q-icon
        size="md"
        :name="reservation.isPaid ? 'check' : 'close'"
        :color="reservation.isPaid ? 'positive' : 'negative'"
      />
    </inline-data>
    <inline-data label="En uso">
      <q-icon
        size="md"
        :name="reservation.isUsed ? 'check' : 'close'"
        :color="reservation.isUsed ? 'positive' : 'negative'"
      />
    </inline-data>

    <q-separator />

    <h4>QR</h4>

    <inline-data label="URL de QR">
      {{ reservation.qrUrl }}
    </inline-data>

    <q-img
      class="qr-code"
      :src="reservation.qrUrl"
    />

    <q-dialog v-model="modalDelete">
      <delete-dialog :reservation="reservation" />
    </q-dialog>
  </page-with-actions>
</template>

<script setup>
import { onMounted, computed } from 'vue'

import modalFactory from 'src/composable/modalFactory'
import environment from 'src/composable/environment'
import { pull } from 'src/utils/api'

import PageWithActions from 'components/shared/pages/PageWithActions.vue'
import Action from 'components/shared/stickyButtons/Action.vue'
import InlineData from 'components/shared/InlineData.vue'
import DeleteDialog from 'components/dialogs/reservations/DeleteDialog.vue'

const { store, quasar, route } = environment()

const reservation = computed(() => store.getters['reservations/reservation'])

const [modalDelete, showModalDelete] = modalFactory()

const editRoute = computed(() => ({
  name: 'reservations edit',
  params: { reservationId: reservation.value?.id ?? '' }
}))

onMounted(async () => {
  if (!reservation.value) {
    await pull(store, quasar, 'reservations/get', route.params.reservationId)
  }
})

</script>
