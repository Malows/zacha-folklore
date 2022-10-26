import Generic from './Generic'
import { handle } from './Response'

class TransitiveGeneric extends Generic {
  /**
   * Get the url for the resource.
   */
  constructor (urlBase, interceptors, parentSection, idParent, resourceSection, idProperty = 'id') {
    super(urlBase, interceptors, idProperty)
    this.parentSection = parentSection
    this.idParent = idParent
    this.resourceSection = resourceSection
  }

  /**
   * Format the url according the payload parameter.
   *
   * @param {Record<string, unknown>|undefined} payload
   *
   * @returns {string}
   */
  transitiveUrl (payload) {
    return `${this._url}/${this.parentSection}/${payload[this.idParent]}/${this.resourceSection}`
  }

  /**
   * Format the url according the payload parameter.
   *
   * @param {Record<string, unknown>|undefined} payload
   *
   * @returns {string}
   */
  url (payload) {
    return `${this._url}/${this.resourceSection}/${payload[this._idProperty]}`
  }

  /**
   * Fetch the list of resources.
   *
   * @param {UrlParameter} payload
   *
   * @returns {Promise<HttpResponse<T[]>>}
   */
  fetch (payload) {
    return handle(
      fetch(this.transitiveUrl(payload), {
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
      fetch(this.transitiveUrl(payload), {
        headers: this.authHeader(),
        method: 'POST',
        body: JSON.stringify(this.onRequest(payload))
      }),
      this.onResponse,
      this.onListResponse
    )
  }
}

export default TransitiveGeneric
