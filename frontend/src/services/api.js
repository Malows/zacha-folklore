export const HOST = process.env.HOST || ''
export const URL = `${HOST}/api`

// session
export const LOGIN = `${HOST}/oauth/token`
export const USER_URL = `${URL}/user`

// crud
export const RESERVATIONS_URL = `${URL}/reservations`
// export const PRODUCTS_URL = `${URL}/menu`
export const MENU_SECTIONS_URL = `${URL}/menu_sections`
export const MENU_ITEMS_URL = `${URL}/menu_items`
export const USERS_URL = `${URL}/users`
