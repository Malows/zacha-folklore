import Generic from './Generic'
import TransitiveGeneric from './TransitiveGeneric'
import { handle } from './Response'
import { EVENTS_URL, RESERVATIONS_URL, USERS_URL, URL } from './api'

import * as eventsInterceptors from './interceptors/events'
import * as itemsInterceptors from './interceptors/menuItems'
import * as menuInterceptors from './interceptors/menuSections'
import * as reservationsInterceptors from './interceptors/reservations'
import * as usersInterceptors from './interceptors/users'

class ReservationService extends TransitiveGeneric {
  /**
   * Fetch the individual resource.
   *
   * @param {UrlParameter} payload
   *
   * @returns {Promise<HttpResponse>}
   */
  uuid (payload) {
    const url = `${RESERVATIONS_URL}/uuid/${payload.id}`

    return handle(
      fetch(url, {
        headers: this.commonHeader()
      }),
      this.onResponse,
      this.onListResponse
    )
  }
}

export const eventService = new Generic(EVENTS_URL, eventsInterceptors)
export const userService = new Generic(USERS_URL, usersInterceptors)

export const reservationService = new ReservationService(
  URL,
  reservationsInterceptors,
  'events',
  'eventId',
  'reservations'
)

export const menuSectionService = new TransitiveGeneric(
  URL,
  menuInterceptors,
  'events',
  'eventId',
  'menu_sections'
)

export const menuItemService = new TransitiveGeneric(
  URL,
  itemsInterceptors,
  'menu_sections',
  'menuSectionId',
  'menu_items'
)
