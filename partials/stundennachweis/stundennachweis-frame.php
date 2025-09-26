<?php
$post_id = get_the_ID();
$days = get_field('days', $post_id);
?>
<div class="pdf-container">

    <div post_id="<?php echo $post_id; ?>" class="pdf-frame">
        <div class="top-header">Verein für Sozialpädagogik e.V. Holenberg</div>
        <div class="header">
            <h2>Stundennachweis</h2>
            <div class="table">
                <div class="col">
                    <div class="cell --dark">Vorname, Nachname</div>
                    <div class="cell --dark">Betriebsstätte</div>
                    <div class="cell --dark">für Monat/Jahr:</div>
                    <div class="cell --dark">Bezahlte Std./Woche (SOLL)</div>
                </div>
                <div class="col">
                    <div class="cell">Silke Stehrenberg</div>
                    <div class="cell">Betrieb</div>
                    <div class="cell">September 2025</div>
                    <div class="cell">30 Stunden</div>
                </div>
                <div class="col">
                    <div class="cell --dark">Bitte ausfüllen</div>
                    <div class="cell small center three-cell light">
                        <span> Bitte <b>umgehend</b> nach
                            Monatsende im <b>Büro
                                Holzminden</b> abgeben oder
                            mailen unter verwaltung@
                            vfs-holenberg.de. DANKE!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-table">
            <div class="head">

            </div>
            <div class="body">
                <?php
                $groups = array_chunk($days, 7);

                foreach ($groups as $gIndex => $group) :
                ?>
                    <div class="row ">
                        <div class="col full-height">
                            <div class="cell">
                                KW 1
                            </div>
                        </div>

                        <div class="col">
                            <?php foreach ($group as $day) : ?>
                                <div class="cell">
                                    01.09.2025
                                </div>
                            <?php
                            endforeach; ?>
                        </div>
                        <div class="col">
                            <?php foreach ($group as $dIndex => $day) :
                                $index = (($gIndex * 7) + $dIndex + 1);
                            ?>
                                <div class="cell">
                                    <input index="<?php echo $index; ?>" field_name="von" value="<?php echo esc_html($day['von']); ?>" type="text">
                                </div>
                            <?php
                                $index++;
                            endforeach; ?>
                        </div>
                        <div class="col">
                            <?php foreach ($group as $dIndex => $day) :
                                $index = (($gIndex * 7) + $dIndex + 1);
                            ?>
                                <div class="cell">
                                    <input field_name="bis" index="<?php echo $index ?>" value="<?php echo esc_html($day['bis']); ?>" type="text">
                                </div>
                            <?php
                                $index++;
                            endforeach; ?>
                        </div>
                        <div class="col">
                            <?php foreach ($group as $dIndex => $day) :
                                $index = (($gIndex * 7) + $dIndex + 1);
                            ?>
                                <div class="cell">
                                    <input field_name="pause" index="<?php echo $index ?>" value="<?php echo esc_html($day['pause']); ?>" type="text">
                                </div>
                            <?php
                                $index++;
                            endforeach; ?>
                        </div>
                        <div class="col">
                            <?php foreach ($group as $dIndex => $day) :
                                $index = (($gIndex * 7) + $dIndex + 1);
                            ?>
                                <div index="<?php echo $index ?>" class="cell">
                                    <?php
                                    $start = new DateTime($day['von']);
                                    $ende  = new DateTime($day['bis']);

                                    $diff = $start->diff($ende);
                                    $stundenGesamt = ($diff->days * 24) + $diff->h + ($diff->i / 60) - intval($day['pause']);
                                    if (!empty($day['von']) && !empty($day['bis']))
                                        echo $stundenGesamt;
                                    ?>
                                </div>
                            <?php
                                $index++;
                            endforeach; ?>
                        </div>
                        <div class="col">
                            <?php foreach ($group as $dIndex => $day) :
                                $index = (($gIndex * 7) + $dIndex + 1);
                            ?> <div class="cell">
                                    <input field_name="anmerkung" index="<?php echo $index ?>" value="<?php echo esc_html($day['anmerkung']); ?>" type="text">
                                </div>
                            <?php
                                $index++;
                            endforeach; ?>
                        </div>

                        <div class="col full-height">
                            <div class="cell">
                                <?php
                                $week_hours = 0;

                                ?>
                                <?php foreach ($group as $day) :
                                    $start = new DateTime($day['von']);
                                    $ende  = new DateTime($day['bis']);

                                    $diff = $start->diff($ende);
                                    $stundenGesamt = ($diff->days * 24) + $diff->h + ($diff->i / 60) - intval($day['pause']);
                                    $week_hours += $stundenGesamt;
                                ?>
                                <?php endforeach; ?>
                                <?php if ($week_hours > 0) {

                                    echo round($week_hours, 2);
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </div>

        </div>
    </div>
</div>
<button id="download">Download</button>
<button id="updateRepeater">Update</button>
<div class="loading"></div>