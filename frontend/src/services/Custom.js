import Service from './Service'
import { handle } from './Response'
import { URL } from './api'
import * as eventsInterceptors from './interceptors/events'

export class EventExtraService extends Service {
  withMenu () {
    const url = `${URL}/events_with_menu`

    const res = fetch(url, { headers: this.authHeader() })

    return handle(
      res,
      eventsInterceptors.onResponse,
      eventsInterceptors.onListResponse
    )
  }

  copyMenu (payload) {
    const url = `${URL}/events_copy_menu`

    const res = fetch(url, {
      headers: this.authHeader(),
      method: 'POST',
      body: JSON.stringify(payload)
    })

    return handle(
      res,
      eventsInterceptors.onResponse,
      eventsInterceptors.onListResponse
    )
  }
}
