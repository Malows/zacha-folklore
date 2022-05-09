import genericModule from '../generics'
import { optionsMapper } from '../generics/getters'
import { userService } from 'src/services/Crud'

const users = genericModule({
  singular: 'user',
  plural: 'users',
  collection: 'users',
  service: userService,
  namespace: false,
  state: () => ({
    users: []
  })
})

users.getters = optionsMapper(users.getters, { collection: 'users' })

export default users
