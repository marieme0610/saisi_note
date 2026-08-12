<?php

function getMoyenne(int $id_classe,int $id_matiere,int $id_periode ):float{

    $pdo = connexionDB();
    // dd($id_periode);

        $sql ="SELECT
    ROUND(COALESCE(AVG(moyenne_eleve), 0), 2) AS moyenne_general
FROM (
    SELECT
        ev.inscription_id,
        ROUND(
            AVG(
                (
                    COALESCE(ev.devoir1, 0)
                    + COALESCE(ev.devoir2, 0)
                    + 2 * COALESCE(ev.composition, 0)
                ) / 4
            ),
            2
        ) AS moyenne_eleve
    FROM evaluations ev
    INNER JOIN inscriptions i
        ON i.id = ev.inscription_id
    INNER JOIN matiereclasses mc
        ON mc.id = ev.matiere_classe_id
    WHERE i.classe_id = :classe_id
      AND mc.matiere_id = :matiere_id
      AND ev.periode_id = :periode_id
      AND i.anne_scolaire_id = 1
    GROUP BY ev.inscription_id
) AS resultats";

$query = executeQuery($pdo, $sql, [
    'classe_id'=>$id_classe,
    'matiere_id'=>$id_matiere,
    'periode_id'=>$id_periode
        ]);
// dd($query);
    $pdo = null;
    return $query['moyenne_general'];

}

function getNotesClasse(int $id_classe, int $id_matiere, int $id_periode)
{
    $pdo = connexionDB();

    $sql = "
        WITH matiere_selectionnee AS (
            SELECT
                mc.id AS matiere_classe_id,
                mc.classe_id,
                mc.matiere_id,
                m.nom_matiere
            FROM matiereclasses mc
            INNER JOIN matieres m
                ON m.id = mc.matiere_id
            WHERE mc.classe_id = :classe_id
              AND mc.matiere_id = :matiere_id
        )

        SELECT
            e.nomComplet,
            e.matricule,

            COALESCE(ev.devoir1, 0) AS devoir1,
            COALESCE(ev.devoir2, 0) AS devoir2,
            COALESCE(ev.composition, 0) AS composition,

            ROUND(
                (
                    COALESCE(ev.devoir1, 0)
                    + COALESCE(ev.devoir2, 0)
                    + 2 * COALESCE(ev.composition, 0)
                ) / 4,
                2
            ) AS moyenne,

            CASE
                WHEN (
                    COALESCE(ev.devoir1, 0)
                    + COALESCE(ev.devoir2, 0)
                    + 2 * COALESCE(ev.composition, 0)
                ) / 4 >= 16
                    THEN 'Tres bien'

                WHEN (
                    COALESCE(ev.devoir1, 0)
                    + COALESCE(ev.devoir2, 0)
                    + 2 * COALESCE(ev.composition, 0)
                ) / 4 >= 14
                    THEN 'Bien'

                WHEN (
                    COALESCE(ev.devoir1, 0)
                    + COALESCE(ev.devoir2, 0)
                    + 2 * COALESCE(ev.composition, 0)
                ) / 4 >= 12
                    THEN 'Assez bien'

                WHEN (
                    COALESCE(ev.devoir1, 0)
                    + COALESCE(ev.devoir2, 0)
                    + 2 * COALESCE(ev.composition, 0)
                ) / 4 >= 10
                    THEN 'Passable'

                ELSE 'Insuffisant'
            END AS appreciation,

            'OK' AS statut

        FROM inscriptions i

        INNER JOIN eleves e
            ON e.id = i.eleve_id

        INNER JOIN matiere_selectionnee ms
            ON ms.classe_id = i.classe_id

        LEFT JOIN evaluations ev
            ON ev.inscription_id = i.id
            AND ev.matiere_classe_id = ms.matiere_classe_id
            AND ev.periode_id = :periode_id

        WHERE i.classe_id = :classe_id

        UNION ALL

        SELECT
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            'NOT_ENSEIGNEE'

        WHERE NOT EXISTS (
            SELECT 1
            FROM matiere_selectionnee
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'classe_id' => $id_classe,
        'matiere_id' => $id_matiere,
        'periode_id' => $id_periode
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}