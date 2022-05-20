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

reservations.getters = optionsMapper(reservations.getters, { collection: 'reservations' })

reservations.getters.notUsedReservations = function (state) {
  return state.reservations.filter(reservation => !reservation.isUsed)
}

export default reservations
