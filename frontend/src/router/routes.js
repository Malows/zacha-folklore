const routify = (requireAuth) =>
  (path, name, component) =>
    ({
      path,
      name,
      component,
      meta: { requireAuth }
    })

const route = routify(true)
const publicRoute = routify(false)

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      route('', 'home', () => import('pages/IndexPage.vue')),

      route('evento', 'events index', () => import('pages/EventPage.vue')),

      route('eventos', 'events index', () => import('pages/events/IndexPage.vue')),
      route('eventos/crear', 'events create', () => import('pages/events/CreatePage.vue')),
      route('eventos/:eventId', 'events show', () => import('pages/events/ShowPage.vue')),
      route('eventos/:eventId/editar', 'events edit', () => import('pages/events/EditPage.vue')),

      route('menu', 'menu index', () => import('pages/menu/IndexPage.vue')),
      route('menu/crear', 'menu create', () => import('pages/menu/CreatePage.vue')),
      route('menu/:menuSectionId', 'menu show', () => import('pages/menu/ShowPage.vue')),
      route('menu/:menuSectionId/editar', 'menu edit', () => import('pages/menu/EditPage.vue')),

      route('reservas', 'reservations index', () => import('pages/reservations/IndexPage.vue')),
      route('reservas/crear', 'reservations create', () => import('pages/reservations/CreatePage.vue')),
      route('reservas/:reservationId', 'reservations show', () => import('pages/reservations/ShowPage.vue')),
      route('reservas/:reservationId/editar', 'reservations edit', () => import('pages/reservations/EditPage.vue')),
      route('reservas/:reservationId/quick', 'reservations quick', () => import('pages/reservations/QuickPage.vue')),

      route('usuarios', 'users index', () => import('pages/users/IndexPage.vue')),
      route('usuarios/crear', 'users create', () => import('pages/users/CreatePage.vue')),
      route('usuarios/:userId', 'users show', () => import('pages/users/ShowPage.vue')),
      route('usuarios/:userId/editar', 'users edit', () => import('pages/users/EditPage.vue'))
    ]
  },

  {
    path: '/',
    component: () => import('layouts/BlankLayout.vue'),
    children: [
      publicRoute('/login', 'login', () => import('src/pages/LoginPage.vue')),
      publicRoute('qr/:uuid', 'qr', () => import('src/pages/QrPage.vue'))
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
