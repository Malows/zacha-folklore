import { ref } from 'vue'

export default function () {
  const modalValue = ref(false)

  const openModal = () => {
    modalValue.value = true
  }

  return [
    modalValue,
    openModal
  ]
}
