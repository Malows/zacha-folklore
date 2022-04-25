import genericModule from '../generics'
import { optionsMapper } from '../generics/getters'
import { menuSectionService } from 'src/services/Crud'

const sections = genericModule({
  singular: 'menuSection',
  plural: 'menuSections',
  collection: 'menuSections',
  service: menuSectionService,
  state: () => ({
    menuSections: []
  })
})

export default optionsMapper(sections.getters, { collection: 'menuSections' })
