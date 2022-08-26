import Generic from './Generic'
import { handle } from './Response'
import { EVENTS_URL, MENU_ITEMS_URL, MENU_SECTIONS_URL, RESERVATIONS_URL, USERS_URL } from './api'

import * as eventsInterceptors from './interceptors/events'
import * as itemsInterceptors from './interceptors/menuItems'
import * as menuInterceptors from './interceptors/menuSections'
import * as reservationsInterceptors from './interceptors/reservations'
import * as usersInterceptors from './interceptors/users'

class ReservationService extends Generic {
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
export const reservationService = new ReservationService(RESERVATIONS_URL, reservationsInterceptors)
export const menuSectionService = new Generic(MENU_SECTIONS_URL, menuInterceptors)
export const menuItemService = new Generic(MENU_ITEMS_URL, itemsInterceptors)
export const userService = new Generic(USERS_URL, usersInterceptors)
