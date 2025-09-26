
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

// Beispiel-Daten (achte auf gültige Syntax!)
const data = [
    { date: "01.09.2025", von: "08:00", bis: "12:00", pause: 0.5, anmerkung: "Anmerkung" },
    { date: "02.09.2025", von: "09:00", bis: "17:00", pause: 1, anmerkung: "B" },
    { date: "03.09.2025", von: "10:00", bis: "18:00", pause: 0.5, anmerkung: "C" },
    { date: "04.09.2025", von: "08:30", bis: "16:00", pause: 0.5, anmerkung: "D" }
];

jQuery(function ($) {
    $('#updateRepeater').on('click', function () {
        $.ajax({
            url: myplugin.ajax_url,  
            type: 'POST',
            data: {
                action: 'update_repeater',
                nonce: myplugin.nonce, 
                post_id: 13,
                repeater: JSON.stringify(data) 
            },
            success: function (res) { console.log('OK:', res); },
            error: function (xhr) { console.error('Fehler:', xhr.responseText); }
        });
    });
});
