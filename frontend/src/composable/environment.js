import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useQuasar } from 'quasar'

export default function () {
  const store = useStore()
  const router = useRouter()
  const route = useRoute()
  const quasar = useQuasar()

  return {
    store,
    router,
    route,
    quasar
  }
}
