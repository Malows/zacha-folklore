import Generic from './Generic'
import { MENU_ITEMS_URL, MENU_SECTIONS_URL, RESERVATIONS_URL, USERS_URL } from './api'

import * as itemsInterceptors from './interceptors/menuItems'
import * as menuInterceptors from './interceptors/menuSections'
import * as reservationsInterceptors from './interceptors/reservations'
import * as usersInterceptors from './interceptors/users'

export const reservationService = new Generic(RESERVATIONS_URL, reservationsInterceptors)
export const menuSectionService = new Generic(MENU_SECTIONS_URL, menuInterceptors)
export const menuItemService = new Generic(MENU_ITEMS_URL, itemsInterceptors)
export const userService = new Generic(USERS_URL, usersInterceptors)
