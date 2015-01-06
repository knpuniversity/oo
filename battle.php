<?php
require __DIR__.'/functions.php';

$ships = get_ships();

$ship1Name = isset($_POST['ship1_name']) ? $_POST['ship1_name'] : null;
$ship1Quantity = isset($_POST['ship1_quantity']) ? $_POST['ship1_quantity'] : 1;
$ship2Name = isset($_POST['ship2_name']) ? $_POST['ship2_name'] : null;
$ship2Quantity = isset($_POST['ship2_quantity']) ? $_POST['ship2_quantity'] : 1;

if (!$ship1Name || !$ship2Name) {
    header('Location: /index.php?error=missing_data');
    die;
}

if (!isset($ships[$ship1Name]) || !isset($ships[$ship2Name])) {
    header('Location: /index.php?error=bad_ships');
    die;
}

if ($ship1Quantity <= 0 || $ship2Quantity <= 0) {
    header('Location: /index.php?error=bad_quantities');
    die;
}

$ship1 = $ships[$ship1Name];
$ship2 = $ships[$ship2Name];

$outcome = battle($ship1, $ship1Quantity, $ship2, $ship2Quantity);
?>

<html>
    <head>

    </head>
    <body>
        <div>
            You battled
            <?php echo $ship1Quantity; ?> <?php echo $ship1['name']; ?><?php echo $ship1Quantity > 1 ? 's': ''; ?>

            against

            <?php echo $ship2Quantity; ?> <?php echo $ship2['name']; ?><?php echo $ship2Quantity > 1 ? 's': ''; ?>
        </div>

        <h3>
            Winner:
            <?php if ($outcome['winning_ship']): ?>
                <?php echo $outcome['winning_ship']['name']; ?>
            <?php else: ?>
                Nobody
            <?php endif; ?>
        </h3>
        <div>
            <?php if ($outcome['winning_ship'] == null): ?>
                Both ships destroyed each other in an epic battle to the end.
            <?php else: ?>
                The <?php echo $outcome['winning_ship']['name']; ?>
                <?php if ($outcome['used_jedi_powers']): ?>
                    used its Jedi Powers for a stunning victory!
                <?php else: ?>
                    overpowered and destroyed the <?php echo $outcome['losing_ship']['name'] ?>s
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <a href="/index.php">Battle again</a>
    </body>
</html>
