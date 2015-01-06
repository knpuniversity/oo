<?php
require __DIR__.'/functions.php';

$ships = get_ships();

$errorMessage = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_data':
            $errorMessage = 'Don\'t forget to select some ships to battle!';
            break;
        case 'bad_ships':
            $errorMessage = 'You\'re trying to fight with a ship that\'s unknown to the galaxy?';
            break;
        case 'bad_quantities':
            $errorMessage = 'You pick strange numbers of ships to battle - try again.';
            break;
        default:
            $errorMessage = 'There was a disturbance in the force. Try again.';
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <title>OO Battleships</title>

           <!-- Bootstrap -->
           <link href="css/bootstrap.min.css" rel="stylesheet">

           <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
           <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
           <!--[if lt IE 9]>
             <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
             <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
           <![endif]-->
    </head>

    <?php if ($errorMessage): ?>
        <div>
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <body>
        <div class="container">
            <div class="page-header">
                <h1>OO Battleships of Space</h1>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ship</th>
                        <th>Weapon Power</th>
                        <th>Jedi Factor</th>
                        <th>Strength</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ships as $ship): ?>
                        <tr>
                            <td><?php echo $ship['name']; ?></td>
                            <td><?php echo $ship['weapon_power']; ?></td>
                            <td><?php echo $ship['jedi_factor']; ?></td>
                            <td><?php echo $ship['strength']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="POST" action="/battle.php">
                Battle
                <input type="text" name="ship1_quantity" value="1" />
                <select name="ship1_name">
                    <option value="">-- Choose a Ship--</option>
                    <?php foreach ($ships as $key => $ship): ?>
                        <option value="<?php echo $key; ?>"><?php echo $ship['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                against

                <input type="text" name="ship2_quantity" value="1" />
                <select name="ship2_name">
                    <option value="">-- Choose a Ship--</option>
                    <?php foreach ($ships as $key => $ship): ?>
                        <option value="<?php echo $key; ?>"><?php echo $ship['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Battle!</button>
            </form>
        </div>
    </body>
</html>
