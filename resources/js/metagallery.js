import Alpine from 'alpinejs'
import { Gallery } from './api'

window.Alpine = Alpine

Gallery.all().then(({ data }) => {
    console.log(data)
})

// Hide nags
Array.from(document.querySelectorAll('#wpbody-content > *:not(#metagallery-app)')).forEach(
    (element) => (element.style.display = 'none'),
)
