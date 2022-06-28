<?php
include 'include/bdd.php';

session_start();

?>

<html>

<head>
    <meta charset="utf-8">
    <title>Prise de rendez vous </title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/fr.js"></script>
</head>

<body>
    <?php
    if ($_SESSION["id_role"] == 4) {
    ?>
        <script>
            if (window.history.replaceState) { // don't resend forms on reload/back
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    <?php
    }
    ?>
    <dialog id="editionModal">
        <form method="dialog">
            <button>X</button>
        </form>
        <h1>Prendre rendez-vous le <span class="day"></span> à <span class="time"></span></h1>

        <form action="./addEvent.php" method="post">
            <label for="profesional">veuillez selectioner un profesionnel:</label>
            <select name="profesional" id="profesional"></select>
            <input type="hidden" name="date" id="date" value="">


            <button type="submit">Prendre rendez-vous</button>
        </form>
    </dialog>
    <nav class="navtop">
        <div>
            <h1>Prise de rendez vous </h1>
        </div>
    </nav>
    <div class="content home">
        <div id="calendar"></div>
    </div>
    <?php
    if ($_SESSION["id_role"] == 4) {
    ?>
        <div class="valid_rdv">
            <?php
            $bdd = getPDO();
            $request = $bdd->prepare(
                "SELECT rdvByUser.id, name , surname, date FROM user INNER JOIN rdvByUser ON user.id = rdvByUser.idUser WHERE rdvByUser.is_validate=0"
            );
            $request2 = $bdd->prepare(
                "SELECT rdvByUser.id, name , surname FROM user INNER JOIN rdvByUser ON user.id = rdvByUser.idPro WHERE rdvByUser.is_validate=0"
            );
            $request2->execute();
            $request->execute();

            $results = $request->fetchAll(PDO::FETCH_ASSOC);
            $results2 = $request2->fetchAll(PDO::FETCH_ASSOC);

            $json = json_encode($results);
            $json2 = json_encode($results2);
            $i = 0;
            $bdd = getPDO();
            if (isset($_POST["is_valider"])) {
                $id = ($_POST["nomdemavaleur"]);
                if ($_POST["is_valider"] == "refuser") {
                    $request = $bdd->prepare(
                        "DELETE FROM `rdvByUser`
                    WHERE id=$id"
                    );
                } elseif ($_POST["is_valider"] == "valider") {
                    $request = $bdd->prepare(
                        "UPDATE rdvByUser
                    SET is_validate = 1
                    WHERE id=$id"
                    );
                }
                $request->execute();
                $results = $request->fetchAll(PDO::FETCH_ASSOC);
            }
            while ($i < count($results)) {
                $id = $results[$i]["id"];
                $name = $results[$i]["name"];
                $namePro = $results2[$i]["name"];
                $surname = $results[$i]["surname"];
                $date = $results[$i]["date"];
                $i = $i + 1;
                echo ("$surname $name demande un rendez-vous le $date avec le DR. $namePro")
            ?>

                <form name="form_validate" method="post">
                    <div>
                        <input type="radio" id="is_validate" name="is_valider" value="valider" />
                        <label for="valider">Valider</label>
                    </div>
                    <input type="hidden" value=<?php echo $id ?> name="nomdemavaleur" />

                    <div>
                        <input type="radio" id="refuser" name="is_valider" value="refuser" />
                        <label for="refuser">Refuser</label>
                    </div>
                    <input type="submit" class="buttonvalidate" value="Envoyer">
                </form>
            <?php
            }

            ?>
        </div>
    <?php
    }
    ?>

    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            const modal = document.getElementById('editionModal');
            const calendarEl = document.getElementById('calendar');
            const dayEl = document.querySelector(".day");
            const timeEl = document.querySelector(".time");



            const profesionalSelectEl = document.querySelector('#profesional');
            const appointments = await fetch('./getListRdv.php').then((res) => res.json());

            const events = [];

            for (const appointment of appointments) {
                const endDate = new Date(appointment.date);
                endDate.setMinutes(endDate.getMinutes() + (appointment.time));
                events.push({
                    title: `${appointment.type} with Dr. ${appointment.surname} ${appointment.name}`,
                    start: new Date(appointment.date),
                    end: endDate
                })
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {

                slotMinTime: "07:00:00",
                slotMaxTime: "19:00:00",
                weekends: false,
                initialView: 'timeGridWeek',
                allDaySlot: false,
                locale: "fr",
                events,
                dateClick: async (info) => {
                    const profesionals = await fetch('./getProfesionals.php').then((res) => res.json());
                    console.log(profesionals)

                    for (const profesional of profesionals) {

                        const newOption = document.createElement('option');
                        newOption.value = [profesional.id, profesional.typeID];
                        newOption.text = `${profesional.surname} ${profesional.name} - ${profesional.type}`
                        profesionalSelectEl.add(newOption);

                    }


                    modal.showModal();
                    dayEl.textContent = info.date.toLocaleDateString();
                    timeEl.textContent = info.date.toLocaleTimeString();
                    document.getElementById("date").value = info.dateStr




                },
            });
            calendar.render();
        })
    </script>
</body>

</html>