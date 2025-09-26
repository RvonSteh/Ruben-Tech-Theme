<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="pdf-mask">
    <div class="input-data">
        <div class="input">
            <div class="row day">
                <label for="date">Datum</label>
                <select name="" id="date">
                    <option value="01.09.2025">01.09.2025</option>
                    <option value="02.09.2025">02.09.2025</option>
                    <option value="03.09.2025">03.09.2025</option>
                    <option value="04.09.2025">04.09.2025</option>
                    <option value="05.09.2025">05.09.2025</option>
                    <option value="06.09.2025">06.09.2025</option>
                    <option value="07.09.2025">07.09.2025</option>
                    <option value="08.09.2025">08.09.2025</option>
                    <option value="09.09.2025">09.09.2025</option>
                    <option value="10.09.2025">10.09.2025</option>
                    <option value="11.09.2025">11.09.2025</option>
                    <option value="12.09.2025">12.09.2025</option>
                    <option value="13.09.2025">13.09.2025</option>
                    <option value="14.09.2025">14.09.2025</option>
                </select>
            </div>
            <div class="row from">
                <label for="from">Arbeitsbeginn</label>
                <input placeholder="z.B.: 07:15" id="from" type="text">
            </div>
            <div class="row day">
                <label for="to">Arbeitsende</label>
                <input placeholder="z.B.: 16:00" id="to" type="text">
            </div>
            <div class="row day">
                <label for="anmerkung">Arbeitsende</label>
                <input placeholder="z.B.: Eleternabend" id="anmerkung" type="text">
            </div>
        </div>
        <div class="message"></div>
        <div class="actions">
            <button class="transmitted">Daten übertagen</button>
            <button disabled class="safe-post-data">Speichern</button>

        </div>

    </div>
    <div></div>
</div>