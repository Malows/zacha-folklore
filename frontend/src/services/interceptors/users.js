export function onRequest (user) {
  const data = {
    name: user.name,
    email: user.email,
    phone: user.phone,
    roles: user.roles
  }

  if (user.id) {
    data.id = user.id
  }

  if (user.password) {
    data.password = user.password
    data.password_confirmation = user.passwordConfirmation
  }

  return data
}

export function onResponse (user) {
  return {
    id: user.id,
    name: user.name,
    email: user.email,
    roles: user?.roles.map(x => x.name) ?? []
  }
}

export function onListResponse (users) {
  return users.map(onResponse)
}
