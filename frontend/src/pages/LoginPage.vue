<template>
  <q-page
    class="flex flex-center justify-center"
    padding
  >
    <div class="row full-width justify-center">
      <q-card class="my-card shadow-8 col col-sm-7 col-md-5 col-lg-4">
        <q-card-section class="bg-primary text-white q-pt-lg">
          <h4>{{ name }}</h4>
        </q-card-section>

        <q-separator inset />

        <q-card-section>
          <q-form @submit="submitLogin">
            <q-input
              v-model="username"
              type="text"
              label="E-mail"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Campo obligatorio']"
            />

            <q-input
              v-model="password"
              :type="passwordMeta.type"
              label="Contraseña"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Campo obligatorio']"
            >
              <template #append>
                <q-icon
                  class="cursor-pointer"
                  :name="passwordMeta.icon"
                  @click="isPassword = !isPassword"
                />
              </template>
            </q-input>

            <div class="text-center q-mt-lg">
              <q-btn
                class="full-width"
                label="Guardar"
                type="submit"
                size="lg"
                color="primary"
              />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { task } from 'src/utils/api'

const router = useRouter()

const name = process.env.NAME

const username = ref('')
const password = ref('')
const isPassword = ref(true)

const payload = computed(() => ({
  username: username.value,
  password: password.value
}))

const passwordMeta = computed(() =>
  isPassword.value
    ? {
        icon: 'visibility',
        type: 'password'
      }
    : {
        icon: 'visibility_off',
        type: 'text'
      }
)

const submitLogin = async () => {
  task(this, 'session/login', payload.value)
    .then(() => {
      router.push({ name: 'home' })
    })
}
</script>
