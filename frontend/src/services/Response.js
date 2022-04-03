class HttpResponse {
  constructor (res) {
    this.isOk = res.isOk
    this.code = res.code
    this.error = res.error
    this.message = res.message
    this.data = res.data
  }
}

export default HttpResponse

export async function handle (fetchPromise) {
  const load = new HttpResponse({})

  try {
    const res = await fetchPromise
    load.isOk = res.ok
    load.code = res.status
    load.message = ''
    load.error = null
    load.data = await res.json()
  } catch (error) {
    const _error = error
    load.isOk = false
    load.message = _error.message || _error.statusText
    load.error = _error
    load.code = -1
    load.data = null
  }

  return load
}
