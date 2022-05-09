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

export default reservations