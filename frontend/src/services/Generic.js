import Service from './Service'
import { handle } from './Response'

/**
 * Generic CRUD service
 */
class Generic extends Service {
  /**
   * Get the url for the resource.
   */
  constructor (url, interceptors, idProperty = 'id') {
    super()
    this._url = url
    this._idProperty = idProperty
    this.onRequest = interceptors.onRequest
    this.onResponse = interceptors.onResponse
    this.onListResponse = interceptors.onListResponse
  }

  /**
   * Format the url according the payload parameter.
   *
   * @param {Record<string, unknown>|undefined} parameter
   *
   * @returns {string}
   */
  url (parameter) {
    return parameter
      ? `${this._url}/${String(parameter[this._idProperty])}`
      : this._url
  }

  /**
   * Fetch the list of resources.
   *
   * @returns {Promise<HttpResponse<T[]>>}
   */
  fetch () {
    return handle(
      fetch(this.url(), {
        headers: this.authHeader()
      }),
      this.onResponse,
      this.onListResponse
    )
  }

  /**
   * Fetch the individual resource.
   *
   * @param {UrlParameter} payload
   *
   * @returns {Promise<HttpResponse>}
   */
  get (payload) {
    return handle(
      fetch(this.url(payload), {
        headers: this.authHeader()
      }),
      this.onResponse,
      this.onListResponse
    )
  }

  /**
   * Create a new resource.
   *
   * @param {UrlParameter} payload
   *
   * @returns {Promise<HttpResponse>}
   */
  create (payload) {
    return handle(
      fetch(this.url(), {
        headers: this.authHeader(),
        method: 'POST',
        body: JSON.stringify(this.onRequest(payload))
      }),
      this.onResponse,
      this.onListResponse
    )
  }

  /**
   * Update the resource.
   *
   * @param {UrlParameter} payload
   *
   * @returns {Promise<HttpResponse>}
   */
  update (payload) {
    return handle(
      fetch(this.url(payload), {
        headers: this.authHeader(),
        method: 'PUT',
        body: JSON.stringify(this.onRequest(payload))
      }),
      this.onResponse,
      this.onListResponse
    )
  }

  /**
   * Delete the resource.
   *
   * @param {UrlParameter} payload
   *
   * @returns {Promise<HttpResponse>}
   */
  remove (payload) {
    return handle(
      fetch(this.url(payload), {
        headers: this.authHeader(),
        method: 'DELETE'
      }),
      this.onResponse,
      this.onListResponse
    )
  }
}

export default Generic
