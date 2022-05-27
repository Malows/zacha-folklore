import { onListResponse as itemsListResponse } from './menuItems'

export function onRequest (section) {
  const data = {
    name: section.name,
    order: section.order
  }

  if (section.id) {
    data.id = section.id
  }

  return data
}

export function onResponse (section) {
  return {
    id: section.id,
    name: section.name,
    order: section.order,
    items: itemsListResponse(section.items ?? [])
  }
}

export function onListResponse (sections) {
  return sections.map(onResponse)
}
