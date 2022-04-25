import Service from './Service'
import { handle } from './Response'

class SessionService extends Service {
  constructor ({ prefix, clientSecret, clientID, url, oauthURI, profileURI }) {
    super(prefix)

    url = url ?? 'http://localhost:8000'
    oauthURI = oauthURI ?? '/oauth/token'
    profileURI = profileURI ?? '/api/user'

    this.clientSecret = clientSecret
    this.clientID = clientID
    this.loginURL = url + oauthURI
    this.userURL = url + profileURI
  }

  login ({ username, password }) {
    const body = JSON.stringify({
      username,
      password,
      client_secret: this.clientSecret,
      client_id: this.clientID,
      grant_type: 'password',
      scope: '*'
    })

    return handle(fetch(this.loginURL, {
      method: 'POST',
      headers: this.commonHeader(),
      body
    }))
  }

  fetchUserData () {
    const headers = this.authHeader()

    return handle(fetch(this.userURL, { headers }))
  }
}

export default SessionService
