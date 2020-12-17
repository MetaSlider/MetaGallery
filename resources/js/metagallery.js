import Alpine from 'alpinejs'
import { Gallery } from './api'

// Hide nags - Doing this here instead of with CSS keeps users from thinking they have a blank screen
// when another plugin has JS code running and breaking things.
Array.from(document.querySelectorAll('#wpbody-content > *:not(#metagallery-app)')).forEach(
    (element) => (element.style.display = 'none'),
)

window.Alpine = Alpine

Gallery.all().then(({ data }) => {
    console.log(data)
})
