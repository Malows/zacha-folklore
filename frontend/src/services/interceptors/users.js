export function onRequest (user) {
  const data = {
    name: user.name,
    email: user.email,
    phone: user.phone
  }

  if (user.id) {
    data.id = user.id
  }

  return data
}

export function onResponse (user) {
  return {
    id: user.id,
    name: user.name,
    email: user.email,
    phone: user.phone
  }
}

export function onListResponse (users) {
  return users.map(onResponse)
}
