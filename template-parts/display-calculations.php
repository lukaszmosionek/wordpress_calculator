<?php
$calculations = array();
if (($handle = fopen(get_template_directory() . '/calculations.csv', 'r')) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
        $calculations[] = $data;
    }
    fclose($handle);
}
usort($calculations, function($a, $b) {
    return strtotime($b[0]) - strtotime($a[0]);
});
?>
<div id="calculations-display">
    <h2>Saved Calculations</h2>
    <ul>
        <?php foreach ($calculations as $calculation) : ?>
            <li><?php echo implode(' | ', $calculation); ?></li>
        <?php endforeach; ?>
    </ul>
</div>