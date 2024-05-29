class iconClearX {
    constructor() {
        this.xIcons = document.querySelectorAll('span.svg-x-icon')

        if (this.xIcons?.length !== 0) {
            this.handleIconsXClick()
        }

    }

    handleIconsXClick() {
        this.xIcons.forEach((icon) => {
            icon.addEventListener('click', () => {
                const inputNearIcon = icon.parentNode.querySelector('input')

                if (!inputNearIcon) {
                    return false
                }

                inputNearIcon.value = ''
                inputNearIcon.dispatchEvent(
                    new Event('change')
                )
                
            })
        })
    }

}

document.addEventListener('DOMContentLoaded', () => new iconClearX)