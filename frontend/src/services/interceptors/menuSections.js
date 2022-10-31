import { onListResponse as itemsListResponse } from './menuItems'

export function onRequest (section) {
  const data = {
    name: section.name,
    order: section.order
  }

  if (section.id) {
    data.id = section.id
  }

  if (section.eventId) {
    data.event_id = section.eventId
  }

  return data
}

export function onResponse (section) {
  return {
    id: section.id,
    name: section.name,
    order: section.order,
    eventId: section.event_id,
    items: itemsListResponse(section.menu_items ?? [])
  }
}

export function onListResponse (sections) {
  return sections.map(onResponse)
}
