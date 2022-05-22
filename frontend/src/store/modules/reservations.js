import genericModule from '../generics'
import { optionsMapper } from '../generics/getters'
import { reservationService } from 'src/services/Crud'

const reservations = genericModule({
  singular: 'reservation',
  plural: 'reservations',
  collection: 'reservations',
  service: reservationService,
  namespace: false,
  state: () => ({
    reservations: []
  })
})

reservations.actions.get = async function ({ commit }, id) {
  const payload = typeof id === 'object'
    ? id
    : { id }

  const response = payload.id.toString().length === 36
    ? await reservationService.uuid(payload)
    : await reservationService.get(payload)

  if (response.isOk) {
    commit('setReservation', response.data)
  }
  return response
}

reservations.getters = optionsMapper(reservations.getters, { collection: 'reservations' })

reservations.getters.notUsedReservations = function (state) {
  return state.reservations.filter(reservation => !reservation.isUsed)
}

export default reservations
