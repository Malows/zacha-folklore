import genericModule from '../generics'
import { optionsMapper } from '../generics/getters'
import { menuSectionService } from 'src/services/Crud'

const sections = genericModule({
  singular: 'menuSection',
  plural: 'menuSections',
  collection: 'menuSections',
  service: menuSectionService,
  namespace: false,
  state: () => ({
    menuSections: []
  })
})

sections.getters = optionsMapper(sections.getters, { collection: 'menuSections' })

export default sections
