/**
 *
 * @param {*} response
 * @returns
 */
function fromServerError (response) {
  return {
    timeout: 5000,
    message: response.data.message
  }
}

/**
 *
 * @param {*} response
 * @returns
 */
function fromValidationError (response) {
  const errors = Object.values(response.data.errors ?? {}).flat(2)

  const messages = errors.join('\n\n')

  const errorsPoints = errors.length

  return {
    timeout: 3000 * (errorsPoints + 1),
    message: `${response.data.message} ${messages}`
  }
}

/**
 *
 * @param {*} store
 * @param {*} quasar
 * @param {*} action
 * @param {*} payload
 * @returns
 */
export async function task (store, quasar, action, payload) {
  quasar.loading.show()
  const response = await store.dispatch(action, payload)
  quasar.loading.hide()

  if (!response.isOk) {
    const data = response.code === 422
      ? fromValidationError(response)
      : fromServerError(response)

    quasar.notify({
      color: 'negative',
      ...data
    })
  }
  return response
}

/**
 *
 * @param {*} store
 * @param {*} quasar
 * @param {*} action
 * @param {*} payload
 * @returns
 */
export async function pull (store, quasar, action, payload) {
  quasar.loading.show()

  const response = payload
    ? await store.dispatch(action, payload)
    : await store.dispatch(action)

  quasar.loading.hide()

  return response
}

/**
 *
 * @param {*} store
 * @param {*} quasar
 * @param {*} actions
 * @returns
 */
export async function pullMany (store, quasar, actions) {
  quasar.loading.show()

  return Promise.all(
    actions.map(x => store.dispatch(...x))
  ).finally(() => {
    quasar.loading.hide()
  })
}
