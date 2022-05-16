<template>
  <q-card>
    <q-card-section>
      <div class="text-h6 q-mb-sm">
        Cambiar contraseña
      </div>
    </q-card-section>

    <q-card-section>
      <q-password
        v-model="password"
        label="Contraseña"
      />
      <q-password
        v-model="passwordConfirmation"
        label="Confirmar contraseña"
      />
    </q-card-section>

    <q-card-actions align="right">
      <q-btn
        color="primary"
        label="Cambiar"
        @click="submit"
      />
      <q-btn
        v-close-popup
        flat
        color="primary"
        label="Cancelar"
      />
    </q-card-actions>
  </q-card>
</template>

<script setup>
import { ref } from 'vue'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'

import { task } from 'src/utils/api'

import QPassword from 'components/QPassword.vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const store = useStore()
const quasar = useQuasar()

const password = ref('')
const passwordConfirmation = ref('')

function submit () {
  // validation
  // ...
  task(store, quasar, 'users/changePassword', {
    id: props.user.id,
    password: password.value,
    password_confirmation: passwordConfirmation.value
  })
}
</script>
