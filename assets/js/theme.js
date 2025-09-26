class Stundennachweis {
    constructor() {
        this.$root = document;
        this.$pdf = this.$root.querySelector('.pdf-frame');
        this.$cells = this.$pdf.querySelectorAll('.cell input');
        this.$dates = this.$pdf.querySelectorAll('.cell.date')
        this.$updateButton = this.$root.querySelectorAll('.safe-post-data');
        this.$downloadPDF = this.$root.querySelector('#download');
        this.$loading = this.$root.querySelector('.loading');
        this.$postId = this.$pdf.getAttribute('post_id');


        // Eingabemaske

        this.$mask = this.$root.querySelector('.pdf-mask');
        this.$maskInputs = this.$mask.querySelectorAll('input, select');
        this.$transmitted = this.$mask.querySelector('button.transmitted');
        this.$maskMessage = this.$mask.querySelector('.message');

        // Toggle Mask

        this.$globalActons = this.$root.querySelector('.global-actions .switcher')
        this.$buttons = this.$globalActons.querySelectorAll('span');
    }
    mount() {
        this.$updateButton.forEach(saveData => {
            saveData.addEventListener('click', () => {
                this.safeChanges();
            })
        });

        this.$downloadPDF.addEventListener('click', () => {
            this.download();
        })
        this.transmittData();
        this.toggleMask();
    }

    toggleMask() {
        this.$buttons.forEach(button => {
            button.addEventListener('click', () => {
                const att = button.getAttribute('value');
                this.$globalActons.setAttribute('att', att);
                this.$mask.setAttribute('att', att);
            })
        });
    }
    transmittData() {
        this.$transmitted.addEventListener('click', () => {
            let currentIndex = null;
            let timeFrom = null;
            let timeTo = null;
            let anmerkung = null;

            // Eingabemaske auslesen
            for (const input of this.$maskInputs) {
                const field = input.getAttribute('name') || input.getAttribute('data-field') || input.id;

                if (field === 'date') {
                    const currentDate = (input.value || '').trim();
                    if (!currentDate) continue;

                    const dateEl = Array.from(this.$dates).find(el => el.textContent.trim() === currentDate);
                    if (dateEl) currentIndex = dateEl.getAttribute('data-index') || dateEl.getAttribute('index');
                }
                else if (field === 'from') {
                    timeFrom = input.value
                }
                else if (field === 'to') {
                    timeTo = input.value
                }
                else if (field === 'anmerkung') {
                    anmerkung = input.value
                }
            }

            if (!currentIndex) {
                console.warn('Kein passender Index zur gewählten Datumseingabe gefunden.');
                return;
            }

            this.insertData(currentIndex, timeFrom, timeTo, anmerkung);
        });
    }

    insertData(currentIndex, timeFrom, timeTo, anmerkung) {
        const selector = `.cell input[data-index="${currentIndex}"], .cell input[index="${currentIndex}"]`;
        const insertCells = document.querySelectorAll(selector);

        insertCells.forEach(inputEl => {
            const field = inputEl.getAttribute('data-field') || inputEl.getAttribute('field_name') || inputEl.name || '';

            if (field === 'von') {
                inputEl.value = timeFrom;
            } else if (field === 'bis') {
                inputEl.value = timeTo;
            } else if (field === 'anmerkung') {
                inputEl.value = anmerkung;
            }
        });
        this.$maskMessage.textContent = "Daten wurde erfolgreich in die Tabelle übertragen. Möchtest du die Tabelle speichern?";
        this.$updateButton.forEach(saveData => {
            saveData.removeAttribute('disabled');

        });

    }


    download() {
        const element = document.querySelector(".pdf-frame");
        const opt = {
            margin: [0, 0, 0, 0],
            pagebreak: {
                mode: ['avoid-all', 'css', 'legacy']
            },
            html2canvas: {
                scale: 10,
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
                    // $('.post-content').html('test');
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