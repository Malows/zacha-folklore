class Service {
  getToken () {
    const prefix = process.env.STORAGE_PREFIX ?? ''

    return localStorage.getItem(`${prefix}_access_token`) || ''
  }

  authHeader () {
    return {
      Authorization: this.getToken(),
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  }

  commonHeader () {
    return {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  }

  authFileHeader () {
    return {
      Authorization: this.getToken(),
      'X-Requested-With': 'XMLHttpRequest'
    }
  }

  commonFileHeader () {
    return {
      'X-Requested-With': 'XMLHttpRequest'
    }
  }
}

export default Service
