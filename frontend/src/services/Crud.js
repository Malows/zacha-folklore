import Generic from './Generic'
import { MENU_ITEMS_URL, MENU_SECTIONS_URL, RESERVATIONS_URL, USERS_URL } from './api'

export const reservationService = new Generic(RESERVATIONS_URL)
export const menuSectionService = new Generic(MENU_SECTIONS_URL)
export const menuItemService = new Generic(MENU_ITEMS_URL)
export const userService = new Generic(USERS_URL)
