class ModalAttentionAge {
    constructor() {

        this.attentionModal = document.querySelector('#attention-age-modal')
        this.btnAttention = this.attentionModal.querySelector('.attention-age-modal__btn')

        this.blur = document.querySelector('#maxed-blur')
        this.ajaxUrl = `/local/components/custom/attention.age/ajax.php`

        this.objModal = new Modal({
            modalSelector: "#attention-age-modal",
        });

        this.objModal.open()
        this.blur.classList.add('active')

        this.hangBtnAttention()
        this.hangClose()
    }

    hangBtnAttention() {
        this.btnAttention.onclick = () => this.fetchSubmitAttention()
    }

    hangClose() {
        this.objModal.onClose = () => this.objModal.open()
    }

    getDataSubmit() {
        const attentionData = new FormData()
        attentionData.append('AGE_APPLY', 'Y')
        return attentionData
    }

    async fetchSubmitAttention()
    {
        await fetch(this.ajaxUrl, {
            'method': 'POST',
            'body': this.getDataSubmit()
        })
        .then(respone => respone.text())
        .then(() => location.reload())
    }

}

document.addEventListener('DOMContentLoaded', () => new ModalAttentionAge())