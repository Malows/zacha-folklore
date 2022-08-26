import genericModule from '../generics'
import { optionsMapper } from '../generics/getters'
import { eventService } from 'src/services/Crud'

const events = genericModule({
  singular: 'event',
  plural: 'events',
  collection: 'events',
  service: eventService,
  namespace: false,
  state: () => ({
    events: []
  })
})

events.getters = optionsMapper(events.getters, { collection: 'events' })

events.getters.activeEvent = function (state) {
  return state.events.find(event => !event.isActive)
}

export default events
