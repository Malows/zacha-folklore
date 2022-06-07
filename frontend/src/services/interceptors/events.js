export function onRequest (item) {
  const data = {
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
    eventDay: item.event_day,
    startedAt: item.started_at,
    isActive: item.is_active
  }
}

export function onListResponse (sections) {
  return sections.map(onResponse)
}
