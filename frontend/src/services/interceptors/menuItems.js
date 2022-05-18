export function onRequest (item) {
  const data = {
    name: item.name,
    price: item.price,
    menu_section_id: item.menuSectionId
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
    price: item.price,
    menuSectionId: item.menu_section_id
  }
}

export function onListResponse (sections) {
  return sections.map(onResponse)
}
