import { GalleryImageMarkup } from './GalleryImage'
export default function Gallery() {
    return {
        muuri: null,
        images: [],
        init() {
            this.images = JSON.parse(JSON.stringify(this.$component('current').images))
            if (!this.images.length) return
            window.metagalleryGrid = new window.Muuri(`[x-id=metagallery-grid-${this.$component('current').data.ID}]`, {
                items: this.images.map((i) => this.buildImage(i)),
                dragSortPredicate: {
                    action: 'move',
                },
                dragEnabled: true,
                layout: {
                    fillGaps: true,
                },
            })
            window.metagalleryGrid.on('move', (_data) => {
                this.$component('current').dirty = true
            })
        },
        addImages(images) {
            if (!window.metagalleryGrid) {
                return this.init()
            }
            window.metagalleryGrid.add(
                images.map((i) => this.buildImage(i)),
                { index: 0 },
            )
        },
        buildImage(image) {
            var itemElem = document.createElement('div')
            var itemTemplate = GalleryImageMarkup(image)
            itemElem.innerHTML = itemTemplate
            return itemElem.firstChild
        },
    }
}
