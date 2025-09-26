class Stundennachweis {
    constructor() {
        this.$root = document;
        this.$pdf = this.$root.querySelector('.pdf-frame');
        this.$cells = this.$pdf.querySelectorAll('.cell input');
        this.$updateButton = this.$root.querySelector('#updateRepeater');
        this.$downloadPDF = this.$root.querySelector('#download');
        this.$loading = this.$root.querySelector('.loading');
        this.$postId = this.$pdf.getAttribute('post_id');

    }
    mount() {
        this.$updateButton.addEventListener('click', () => {
            this.safeChanges();
        })
        this.$downloadPDF.addEventListener('click', () => {
            this.download();
        })
    }
    download() {
        const element = document.querySelector(".pdf-frame");
        const opt = {
            margin: [0, 0, 0, 0],
            pagebreak: {

            },
            html2canvas: {
                scale: 2,
                scrollY: 0
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };


        html2pdf().set(opt).from(element).save();
    }
    safeChanges() {
        this.$loading.classList.add('load');
        const cells = document.querySelectorAll('.cell input');
        const rows = {};

        cells.forEach(cell => {
            const index = cell.getAttribute('index')
            const field = cell.getAttribute('field_name');
            const value = cell.value;

            if (!rows[index]) rows[index] = {};


            rows[index][field] = value;
        });

        const data = Object.keys(rows)
            .sort((a, b) => a - b)
            .map(idx => rows[idx]);
        this.update(data);
    }

    update(data) {
        const self = this;
        jQuery(($) => {
            $.ajax({
                url: myplugin.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'update_repeater',
                    nonce: myplugin.nonce, 
                    post_id: this.$postId, 
                    repeater: JSON.stringify(data)
                },
                success: function (res) {
                    window.location.reload();
                }
            });
        });
    }

}

document.addEventListener('DOMContentLoaded', () => {
    const loadStundennachweis = new Stundennachweis();
    loadStundennachweis.mount();
})