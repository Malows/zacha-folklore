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
   * @param {Record<string, unknown>|undefined} parameter
   *
   * @returns {string}
   */
  transitiveUrl (parameter) {
    return `${this._url}/${this.parentSection}/${String(parameter[this.idParent])}/${this.resourceSection}`
  }

  /**
   * Format the url according the payload parameter.
   *
   * @param {Record<string, unknown>|undefined} parameter
   *
   * @returns {string}
   */
  url (parameter) {
    return `${this._url}/${this.resourceSection}/${String(parameter[this._idProperty])}`
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
