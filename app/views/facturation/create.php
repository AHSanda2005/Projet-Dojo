<?php
//    $mpdf = new \Mpdf\Mpdf();
//    $html = '<h1>Facture</h1><p>Client : '.$destinataire.'</p><p>Montant : '.$montant.' Ar</p>';
//    $mpdf->WriteHTML($html);
//    $mpdf->Output("facture_$id.pdf", \Mpdf\Output\Destination::INLINE);
?>
<div class="container mt-4">
    <h2>Facturation de matériel endommagé</h2>

    <p><strong>Matériel :</strong> <?= htmlspecialchars($item['num_serie']) ?> (<?= htmlspecialchars($type['label']) ?>)</p>
    <p><strong>Responsable :</strong> <?= htmlspecialchars($destinataire) ?></p>
    <p><strong>Montant à facturer :</strong> <?= number_format($montant, 2, ',', ' ') ?> Ar</p>

    <form method="POST" action="/facturation/valider">
        <input type="hidden" name="id_suivi_salle" value="<?= $suivi['id_suivi_salle'] ?>">
        <input type="hidden" name="montant" value="<?= $montant ?>">
        <input type="hidden" name="destinataire" value="<?= htmlspecialchars($destinataire) ?>">
        <button class="btn btn-success">Générer la facture</button>
    </form>
</div>
