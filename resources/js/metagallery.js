import Alpine from 'alpinejs'
import { Gallery } from './api'

window.Alpine = Alpine

Gallery.all().then(({ data }) => {
    console.log(data)
})
