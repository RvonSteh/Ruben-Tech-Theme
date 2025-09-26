
document.getElementById("download").addEventListener("click", () => {

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

})


const updateButton = document.querySelector('#updateRepeater');

updateButton.addEventListener('click', () => {
    const cells = document.querySelectorAll('.cell input');
    const rows = {};

    // Alle Cells durchlaufen
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
    update(data);
})
function update(data) {
    jQuery(function ($) {
        $.ajax({
            url: myplugin.ajax_url,
            type: 'POST',
            data: {
                action: 'update_repeater',
                nonce: myplugin.nonce,
                post_id: 27,
                repeater: JSON.stringify(data)
            },
            success: function (res) { console.log('OK:', res); },
            error: function (xhr) { console.error('Fehler:', xhr.responseText); }
        });

    });
}


