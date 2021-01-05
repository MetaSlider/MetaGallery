export function GalleryImageMarkup(image) {
    return `<div class="item absolute">
        <div class="item-content relative h-full w-full">
            <div
                x-title="Gallery Image"
                x-data="GalleryImage(${image._uid})"
                x-init="init()"
                class="">
                <img
                    class="border-0"
                    :style="imageStyles"
                    width="${image.width}"
                    height="${image.height}"
                    src="${image.src.main.url}"
                    alt="${image.alt}"/>
            </div>
        </div>
    </div>`
}
export function GalleryImage(id) {
    return {
        _uid: id,
        get imageStyles() {
            return `max-width:${this.$component('current').settings.maxImageWidth}px`
        },
        init() {
            setTimeout(() => {
                window.dispatchEvent(
                    new CustomEvent('reset-layout', {
                        detail: {},
                        bubbles: true,
                    }),
                )
            }, 0)
        },
    }
}
