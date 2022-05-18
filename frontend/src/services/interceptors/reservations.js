export function onRequest (reservation) {
  const data = {
    name: reservation.name,
    last_name: reservation.lastName,
    amount: reservation.amount,
    email: reservation?.email,
    phone: reservation?.phone
  }

  if (reservation.id) {
    data.id = reservation.id
  }

  return data
}

export function onResponse (reservation) {
  return {
    id: reservation.id,
    name: reservation.name,
    lastName: reservation.last_name,
    amount: reservation.amount,
    email: reservation.email,
    phone: reservation.phone
  }
}

export function onListResponse (reservations) {
  return reservations.map(onResponse)
}
