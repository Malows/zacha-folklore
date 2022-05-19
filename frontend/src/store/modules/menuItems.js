import genericModule from '../generics'
import { menuItemService } from 'src/services/Crud'

const items = genericModule({
  singular: 'menuItem',
  plural: 'menuItems',
  collection: 'menuItems',
  service: menuItemService,
  namespace: false,
  state: () => ({
    menuItems: [],
    selectedItem: null,
    action: null
  })
})

items.actions.showEditModal = function ({ commit, state }, payload) {
  commit('setSelectedItem', { item: payload, action: 'edit' })
}

items.actions.showDeleteModal = function ({ commit, state }, payload) {
  commit('setSelectedItem', { item: payload, action: 'delete' })
}

items.actions.cleanModal = function ({ commit }) {
  commit('setSelectedItem', { item: null, action: null })
}

items.mutations.setSelectedItem = function (state, { item, action }) {
  state.selectedItem = item
  state.action = action
}

export default items
