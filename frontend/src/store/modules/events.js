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
    events: [],
    selectedEvent: null
  })
})

events.getters = optionsMapper(events.getters, { collection: 'events' })

events.getters.activeEvent = function (state) {
  return state.events.find(event => !event.isActive)
}

events.actions.selectEvent = function ({ commit }, eventId) {
  commit('selectEvent', eventId)
}

events.mutations.selectEvent = function (state, id) {
  state.selectedEvent = state.events.find(x => x.id === id) ?? null
}

export default events
