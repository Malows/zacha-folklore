import { fromPlainString } from 'src/utils/date'

export function onRequest (item) {
  const data = {
    name: item.name,
    location: item.location,
    address: item.address,
    event_day: item.eventDay,
    started_at: item.startedAt,
    is_active: item.isActive
  }

  if (item.id) {
    data.id = item.id
  }

  return data
}

export function onResponse (item) {
  return {
    id: item.id,
    name: item.name,
    location: item.location,
    address: item.address,
    eventDay: fromPlainString(item.event_day),
    // startedAt: item.started_at,
    isActive: Boolean(item.is_active),
    menuSections: item.menuSections,
    menuItems: item.menuItems
  }
}

export function onListResponse (sections) {
  return sections.map(onResponse)
}
