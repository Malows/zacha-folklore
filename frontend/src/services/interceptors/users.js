export function onRequest (user) {
  const data = {
    name: user.name,
    email: user.email,
    phone: user.phone
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
    email: user.email
  }
}

export function onListResponse (users) {
  return users.map(onResponse)
}
