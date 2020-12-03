import { Axios as api } from '../api'

// Note, this is a slow refactor so might appear incomplete
const Gallery = {
    all() {
        return api.get('gallery', {
            params: {},
        })
    },
}

export default Gallery
