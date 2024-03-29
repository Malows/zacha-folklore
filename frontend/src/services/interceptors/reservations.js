import { onResponse as eventResponse } from './events'

export function onRequest (reservation) {
  const data = {
    name: reservation.name,
    last_name: reservation.lastName,
    amount: reservation.amount,
    email: reservation?.email ?? null,
    phone: reservation?.phone ?? null,
    is_paid: reservation.isPaid,
    is_used: reservation.isUsed,
    event_id: reservation.eventId
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
    phone: reservation.phone,
    isPaid: reservation.is_paid,
    isUsed: reservation.is_used,
    qrUrl: reservation.qr_url,
    uuid: reservation.uuid,
    eventId: reservation.event_id,
    event: reservation.event
      ? eventResponse(reservation.event)
      : null
  }
}

export function onListResponse (reservations) {
  return reservations.map(onResponse)
}
