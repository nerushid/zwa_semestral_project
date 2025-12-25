<?php
require_once __DIR__ . '/../includes/config_session.php';
require_once __DIR__ . '/../includes/dbh.inc.php';
require_once __DIR__ . '/includes/mainpage_model.inc.php';
require_once __DIR__ . '/includes/mainpage_view.inc.php';
require_once __DIR__ . '/includes/mainpage_contr.inc.php';

$resultsPerPage = 6;

$sort = $_GET['sort'] ?? 'newest';
if (!isValidSortByFilter($sort)) {
    $sort = 'newest';
}

$conditionsAndParams = setConditionForQuerry($_GET);

$totalListings = get_number_of_listings($pdo, $conditionsAndParams['conditions'], $conditionsAndParams['params']);

$totalPages = ceil($totalListings / $resultsPerPage);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$startFrom = ($page - 1) * $resultsPerPage;

$listings = get_listings_with_limit($pdo, $startFrom, $resultsPerPage, $conditionsAndParams['conditions'], $conditionsAndParams['params'], $sort);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="filterstyle.css">
    <link rel="stylesheet" href="listingstyle.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="logout_dialog.css">

    <script src="filter.js" defer></script>
    <script src="prague_district_input.js" defer></script>
    <script src="logout.js" defer></script>
    <script src="imageslider.js" defer></script>
</head>

<body>
    <header>
        <p id="nestly-logo">NestlyHomes</p>
        
        <div id="right-side">
            <?php print_header($pdo); ?>
        </div>
    </header>

    <dialog id="logout-dialog">
        <menu>
            <h2>Log Out</h2>
            <p>Are you sure you want to log out?</p>
            <div class="dialog-buttons">
                <a href="../includes/logout.inc.php">Yes, Log Out</a>
                <button>Cancel</button>
            </div>
        </menu>
    </dialog>

    <main>
        <section id="filters-section">
            <form action="includes/mainpage.inc.php" method="get">
                <h2>Filters</h2>

                <label for="reset-filters">Reset Filters:</label>
                <button type="button" id="reset-filters">Reset</button>

                <!-- Praha selection -->
                <label for="praha-selectid">Choose Praha:</label>
                <select id="praha-selectid" name="praha">
                    <option value="" <?php if(isset($_GET['praha']) && $_GET['praha'] === '') echo 'selected'; ?>>Any Praha</option>
                    <option value="1" <?php if(isset($_GET['praha']) && $_GET['praha'] === '1') echo 'selected'; ?>>Praha 1</option>
                    <option value="2" <?php if(isset($_GET['praha']) && $_GET['praha'] === '2') echo 'selected'; ?>>Praha 2</option>
                    <option value="3" <?php if(isset($_GET['praha']) && $_GET['praha'] === '3') echo 'selected'; ?>>Praha 3</option>
                    <option value="4" <?php if(isset($_GET['praha']) && $_GET['praha'] === '4') echo 'selected'; ?>>Praha 4</option>
                    <option value="5" <?php if(isset($_GET['praha']) && $_GET['praha'] === '5') echo 'selected'; ?>>Praha 5</option>
                    <option value="6" <?php if(isset($_GET['praha']) && $_GET['praha'] === '6') echo 'selected'; ?>>Praha 6</option>
                    <option value="7" <?php if(isset($_GET['praha']) && $_GET['praha'] === '7') echo 'selected'; ?>>Praha 7</option>
                    <option value="8" <?php if(isset($_GET['praha']) && $_GET['praha'] === '8') echo 'selected'; ?>>Praha 8</option>
                    <option value="9" <?php if(isset($_GET['praha']) && $_GET['praha'] === '9') echo 'selected'; ?>>Praha 9</option>
                    <option value="10" <?php if(isset($_GET['praha']) && $_GET['praha'] === '10') echo 'selected'; ?>>Praha 10</option>
                </select>

                <!-- District selection -->
                <label for="districtid">District:</label>
                <select name="district" id="districtid" disabled>
                    <option value="">Any District</option>
                    
                    <optgroup label="1">
                        <option value="Hradčany" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hradčany') echo 'selected'; ?>>Hradčany</option>
                        <option value="Josefov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Josefov') echo 'selected'; ?>>Josefov</option>
                        <option value="Malá Strana" <?php if(isset($_GET['district']) && $_GET['district'] === 'Malá Strana') echo 'selected'; ?>>Malá Strana</option>
                        <option value="Nové Město" <?php if(isset($_GET['district']) && $_GET['district'] === 'Nové Město') echo 'selected'; ?>>Nové Město</option>
                        <option value="Staré Město" <?php if(isset($_GET['district']) && $_GET['district'] === 'Staré Město') echo 'selected'; ?>>Staré Město</option>
                    </optgroup>

                    <optgroup label="2">
                        <option value="Nusle" <?php if(isset($_GET['district']) && $_GET['district'] === 'Nusle') echo 'selected'; ?>>Nusle</option>
                        <option value="Vinohrady" <?php if(isset($_GET['district']) && $_GET['district'] === 'Vinohrady') echo 'selected'; ?>>Vinohrady</option>
                        <option value="Vyšehrad" <?php if(isset($_GET['district']) && $_GET['district'] === 'Vyšehrad') echo 'selected'; ?>>Vyšehrad</option>
                    </optgroup>

                    <optgroup label="3">
                        <option value="Žižkov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Žižkov') echo 'selected'; ?>>Žižkov</option>
                    </optgroup>

                    <optgroup label="4">
                        <option value="Braník" <?php if(isset($_GET['district']) && $_GET['district'] === 'Braník') echo 'selected'; ?>>Braník</option>
                        <option value="Háje" <?php if(isset($_GET['district']) && $_GET['district'] === 'Háje') echo 'selected'; ?>>Háje</option>
                        <option value="Hodkovičky" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hodkovičky') echo 'selected'; ?>>Hodkovičky</option>
                        <option value="Chodov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Chodov') echo 'selected'; ?>>Chodov</option>
                        <option value="Cholupice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Cholupice') echo 'selected'; ?>>Cholupice</option>
                        <option value="Kamýk" <?php if(isset($_GET['district']) && $_GET['district'] === 'Kamýk') echo 'selected'; ?>>Kamýk</option>
                        <option value="Komořany" <?php if(isset($_GET['district']) && $_GET['district'] === 'Komořany') echo 'selected'; ?>>Komořany</option>
                        <option value="Krč" <?php if(isset($_GET['district']) && $_GET['district'] === 'Krč') echo 'selected'; ?>>Krč</option>
                        <option value="Kunratice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Kunratice') echo 'selected'; ?>>Kunratice</option>
                        <option value="Lhotka" <?php if(isset($_GET['district']) && $_GET['district'] === 'Lhotka') echo 'selected'; ?>>Lhotka</option>
                        <option value="Libuš" <?php if(isset($_GET['district']) && $_GET['district'] === 'Libuš') echo 'selected'; ?>>Libuš</option>
                        <option value="Michle" <?php if(isset($_GET['district']) && $_GET['district'] === 'Michle') echo 'selected'; ?>>Michle</option>
                        <option value="Modřany" <?php if(isset($_GET['district']) && $_GET['district'] === 'Modřany') echo 'selected'; ?>>Modřany</option>
                        <option value="Písnice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Písnice') echo 'selected'; ?>>Písnice</option>
                        <option value="Podolí" <?php if(isset($_GET['district']) && $_GET['district'] === 'Podolí') echo 'selected'; ?>>Podolí</option>
                        <option value="Šeberov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Šeberov') echo 'selected'; ?>>Šeberov</option>
                        <option value="Točná" <?php if(isset($_GET['district']) && $_GET['district'] === 'Točná') echo 'selected'; ?>>Točná</option>
                        <option value="Újezd" <?php if(isset($_GET['district']) && $_GET['district'] === 'Újezd') echo 'selected'; ?>>Újezd</option>
                        <option value="Záběhlice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Záběhlice') echo 'selected'; ?>>Záběhlice</option>
                    </optgroup>

                    <optgroup label="5">
                        <option value="Hlubočepy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hlubočepy') echo 'selected'; ?>>Hlubočepy</option>
                        <option value="Holyně" <?php if(isset($_GET['district']) && $_GET['district'] === 'Holyně') echo 'selected'; ?>>Holyně</option>
                        <option value="Jinonice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Jinonice') echo 'selected'; ?>>Jinonice</option>
                        <option value="Košíře" <?php if(isset($_GET['district']) && $_GET['district'] === 'Košíře') echo 'selected'; ?>>Košíře</option>
                        <option value="Lahovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Lahovice') echo 'selected'; ?>>Lahovice</option>
                        <option value="Lipence" <?php if(isset($_GET['district']) && $_GET['district'] === 'Lipence') echo 'selected'; ?>>Lipence</option>
                        <option value="Lochkov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Lochkov') echo 'selected'; ?>>Lochkov</option>
                        <option value="Malá Chuchle" <?php if(isset($_GET['district']) && $_GET['district'] === 'Malá Chuchle') echo 'selected'; ?>>Malá Chuchle</option>
                        <option value="Motol" <?php if(isset($_GET['district']) && $_GET['district'] === 'Motol') echo 'selected'; ?>>Motol</option>
                        <option value="Radlice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Radlice') echo 'selected'; ?>>Radlice</option>
                        <option value="Radotín" <?php if(isset($_GET['district']) && $_GET['district'] === 'Radotín') echo 'selected'; ?>>Radotín</option>
                        <option value="Řeporyje" <?php if(isset($_GET['district']) && $_GET['district'] === 'Řeporyje') echo 'selected'; ?>>Řeporyje</option>
                        <option value="Slivenec" <?php if(isset($_GET['district']) && $_GET['district'] === 'Slivenec') echo 'selected'; ?>>Slivenec</option>
                        <option value="Smíchov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Smíchov') echo 'selected'; ?>>Smíchov</option>
                        <option value="Sobín" <?php if(isset($_GET['district']) && $_GET['district'] === 'Sobín') echo 'selected'; ?>>Sobín</option>
                        <option value="Stodůlky" <?php if(isset($_GET['district']) && $_GET['district'] === 'Stodůlky') echo 'selected'; ?>>Stodůlky</option>
                        <option value="Třebonice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Třebonice') echo 'selected'; ?>>Třebonice</option>
                        <option value="Velká Chuchle" <?php if(isset($_GET['district']) && $_GET['district'] === 'Velká Chuchle') echo 'selected'; ?>>Velká Chuchle</option>
                        <option value="Zadní Kopanina" <?php if(isset($_GET['district']) && $_GET['district'] === 'Zadní Kopanina') echo 'selected'; ?>>Zadní Kopanina</option>
                        <option value="Zbraslav" <?php if(isset($_GET['district']) && $_GET['district'] === 'Zbraslav') echo 'selected'; ?>>Zbraslav</option>
                        <option value="Zličín" <?php if(isset($_GET['district']) && $_GET['district'] === 'Zličín') echo 'selected'; ?>>Zličín</option>
                    </optgroup>

                    <optgroup label="6">
                        <option value="Břevnov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Břevnov') echo 'selected'; ?>>Břevnov</option>
                        <option value="Bubeneč" <?php if(isset($_GET['district']) && $_GET['district'] === 'Bubeneč') echo 'selected'; ?>>Bubeneč</option>
                        <option value="Dejvice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Dejvice') echo 'selected'; ?>>Dejvice</option>
                        <option value="Liboc" <?php if(isset($_GET['district']) && $_GET['district'] === 'Liboc') echo 'selected'; ?>>Liboc</option>
                        <option value="Lysolaje" <?php if(isset($_GET['district']) && $_GET['district'] === 'Lysolaje') echo 'selected'; ?>>Lysolaje</option>
                        <option value="Nebušice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Nebušice') echo 'selected'; ?>>Nebušice</option>
                        <option value="Přední Kopanina" <?php if(isset($_GET['district']) && $_GET['district'] === 'Přední Kopanina') echo 'selected'; ?>>Přední Kopanina</option>
                        <option value="Ruzyně" <?php if(isset($_GET['district']) && $_GET['district'] === 'Ruzyně') echo 'selected'; ?>>Ruzyně</option>
                        <option value="Řepy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Řepy') echo 'selected'; ?>>Řepy</option>
                        <option value="Sedlec" <?php if(isset($_GET['district']) && $_GET['district'] === 'Sedlec') echo 'selected'; ?>>Sedlec</option>
                        <option value="Střešovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Střešovice') echo 'selected'; ?>>Střešovice</option>
                        <option value="Suchdol" <?php if(isset($_GET['district']) && $_GET['district'] === 'Suchdol') echo 'selected'; ?>>Suchdol</option>
                        <option value="Veleslavín" <?php if(isset($_GET['district']) && $_GET['district'] === 'Veleslavín') echo 'selected'; ?>>Veleslavín</option>
                        <option value="Vokovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Vokovice') echo 'selected'; ?>>Vokovice</option>
                    </optgroup>

                    <optgroup label="7">
                        <option value="Holešovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Holešovice') echo 'selected'; ?>>Holešovice</option>
                        <option value="Troja" <?php if(isset($_GET['district']) && $_GET['district'] === 'Troja') echo 'selected'; ?>>Troja</option>
                    </optgroup>

                    <optgroup label="8">
                        <option value="Bohnice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Bohnice') echo 'selected'; ?>>Bohnice</option>
                        <option value="Březiněves" <?php if(isset($_GET['district']) && $_GET['district'] === 'Březiněves') echo 'selected'; ?>>Březiněves</option>
                        <option value="Čimice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Čimice') echo 'selected'; ?>>Čimice</option>
                        <option value="Dolní Chabry" <?php if(isset($_GET['district']) && $_GET['district'] === 'Dolní Chabry') echo 'selected'; ?>>Dolní Chabry</option>
                        <option value="Ďáblice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Ďáblice') echo 'selected'; ?>>Ďáblice</option>
                        <option value="Karlín" <?php if(isset($_GET['district']) && $_GET['district'] === 'Karlín') echo 'selected'; ?>>Karlín</option>
                        <option value="Kobylisy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Kobylisy') echo 'selected'; ?>>Kobylisy</option>
                        <option value="Libeň" <?php if(isset($_GET['district']) && $_GET['district'] === 'Libeň') echo 'selected'; ?>>Libeň</option>
                        <option value="Střížkov" <?php if(isset($_GET['district']) && $_GET['district'] === 'Střížkov') echo 'selected'; ?>>Střížkov</option>
                    </optgroup>

                    <optgroup label="9">
                        <option value="Běchovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Běchovice') echo 'selected'; ?>>Běchovice</option>
                        <option value="Čakovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Čakovice') echo 'selected'; ?>>Čakovice</option>
                        <option value="Černý Most" <?php if(isset($_GET['district']) && $_GET['district'] === 'Černý Most') echo 'selected'; ?>>Černý Most</option>
                        <option value="Dolní Počernice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Dolní Počernice') echo 'selected'; ?>>Dolní Počernice</option>
                        <option value="Hloubětín" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hloubětín') echo 'selected'; ?>>Hloubětín</option>
                        <option value="Horní Počernice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Horní Počernice') echo 'selected'; ?>>Horní Počernice</option>
                        <option value="Hostavice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hostavice') echo 'selected'; ?>>Hostavice</option>
                        <option value="Hrdlořezy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hrdlořezy') echo 'selected'; ?>>Hrdlořezy</option>
                        <option value="Kbely" <?php if(isset($_GET['district']) && $_GET['district'] === 'Kbely') echo 'selected'; ?>>Kbely</option>
                        <option value="Klánovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Klánovice') echo 'selected'; ?>>Klánovice</option>
                        <option value="Koloděje" <?php if(isset($_GET['district']) && $_GET['district'] === 'Koloděje') echo 'selected'; ?>>Koloděje</option>
                        <option value="Kyje" <?php if(isset($_GET['district']) && $_GET['district'] === 'Kyje') echo 'selected'; ?>>Kyje</option>
                        <option value="Letňany" <?php if(isset($_GET['district']) && $_GET['district'] === 'Letňany') echo 'selected'; ?>>Letňany</option>
                        <option value="Miškovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Miškovice') echo 'selected'; ?>>Miškovice</option>
                        <option value="Prosek" <?php if(isset($_GET['district']) && $_GET['district'] === 'Prosek') echo 'selected'; ?>>Prosek</option>
                        <option value="Satalice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Satalice') echo 'selected'; ?>>Satalice</option>
                        <option value="Třeboradice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Třeboradice') echo 'selected'; ?>>Třeboradice</option>
                        <option value="Újezd nad Lesy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Újezd nad Lesy') echo 'selected'; ?>>Újezd nad Lesy</option>
                        <option value="Vinoř" <?php if(isset($_GET['district']) && $_GET['district'] === 'Vinoř') echo 'selected'; ?>>Vinoř</option>
                        <option value="Vysočany" <?php if(isset($_GET['district']) && $_GET['district'] === 'Vysočany') echo 'selected'; ?>>Vysočany</option>
                    </optgroup>

                    <optgroup label="10">
                        <option value="Benice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Benice') echo 'selected'; ?>>Benice</option>
                        <option value="Dolní Měcholupy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Dolní Měcholupy') echo 'selected'; ?>>Dolní Měcholupy</option>
                        <option value="Dubeč" <?php if(isset($_GET['district']) && $_GET['district'] === 'Dubeč') echo 'selected'; ?>>Dubeč</option>
                        <option value="Hájek" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hájek') echo 'selected'; ?>>Hájek</option>
                        <option value="Horní Měcholupy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Horní Měcholupy') echo 'selected'; ?>>Horní Měcholupy</option>
                        <option value="Hostivař" <?php if(isset($_GET['district']) && $_GET['district'] === 'Hostivař') echo 'selected'; ?>>Hostivař</option>
                        <option value="Kolovraty" <?php if(isset($_GET['district']) && $_GET['district'] === 'Kolovraty') echo 'selected'; ?>>Kolovraty</option>
                        <option value="Královice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Královice') echo 'selected'; ?>>Královice</option>
                        <option value="Křeslice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Křeslice') echo 'selected'; ?>>Křeslice</option>
                        <option value="Lipany" <?php if(isset($_GET['district']) && $_GET['district'] === 'Lipany') echo 'selected'; ?>>Lipany</option>
                        <option value="Malešice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Malešice') echo 'selected'; ?>>Malešice</option>
                        <option value="Nedvězí" <?php if(isset($_GET['district']) && $_GET['district'] === 'Nedvězí') echo 'selected'; ?>>Nedvězí</option>
                        <option value="Petrovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Petrovice') echo 'selected'; ?>>Petrovice</option>
                        <option value="Pitkovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Pitkovice') echo 'selected'; ?>>Pitkovice</option>
                        <option value="Strašnice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Strašnice') echo 'selected'; ?>>Strašnice</option>
                        <option value="Štěrboholy" <?php if(isset($_GET['district']) && $_GET['district'] === 'Štěrboholy') echo 'selected'; ?>>Štěrboholy</option>
                        <option value="Uhříněves" <?php if(isset($_GET['district']) && $_GET['district'] === 'Uhříněves') echo 'selected'; ?>>Uhříněves</option>
                        <option value="Vršovice" <?php if(isset($_GET['district']) && $_GET['district'] === 'Vršovice') echo 'selected'; ?>>Vršovice</option>
                    </optgroup>
                </select>

                <!-- Price range selection -->
                <label>Price Range:</label>
                <div class="range-inputs">
                    <div>
                        <label for="price-from"><i>From</i></label>
                        <input type="number" id="price-from" name="price_from" placeholder="0" min="0" step="1"
                        value="<?php if(isset($_GET['price_from'])) echo htmlspecialchars($_GET['price_from']); ?>">
                    </div>

                    <div>
                        <label for="price-to"><i>To</i></label>
                        <input type="number" id="price-to" name="price_to" placeholder="∞" min="0" step="1"
                        value="<?php if(isset($_GET['price_to'])) echo htmlspecialchars($_GET['price_to']); ?>">
                    </div>
                </div>

                <!-- Area range selection -->
                <label>Area Range (m²):</label>
                <div class="range-inputs">
                    <div>
                        <label for="area-from"><i>From</i></label>
                        <input type="number" id="area-from" name="area_from" placeholder="0" min="0" step="1" 
                        value="<?php if(isset($_GET['area_from'])) echo htmlspecialchars($_GET['area_from']); ?>">
                    </div>
                    <div>
                        <label for="area-to"><i>To</i></label>
                        <input type="number" id="area-to" name="area_to" placeholder="∞" min="0" step="1" 
                        value="<?php if(isset($_GET['area_to'])) echo htmlspecialchars($_GET['area_to']); ?>">
                    </div>
                </div>

                <!-- Layout selection -->
                <label>Choose Layout:</label>
                <div id="layout-checkboxes">
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-1kk" value="1+kk" 
                        <?php if(isset($_GET['layouts']) && in_array("1+kk", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-1kk">1+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-1+1" value="1+1" 
                        <?php if(isset($_GET['layouts']) && in_array("1+1", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-1+1">1+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-2kk" value="2+kk" 
                        <?php if(isset($_GET['layouts']) && in_array("2+kk", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-2kk">2+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-2+1" value="2+1" 
                        <?php if(isset($_GET['layouts']) && in_array("2+1", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-2+1">2+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-3kk" value="3+kk" 
                        <?php if(isset($_GET['layouts']) && in_array("3+kk", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-3kk">3+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-3+1" value="3+1" 
                        <?php if(isset($_GET['layouts']) && in_array("3+1", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-3+1">3+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-4kk" value="4+kk" 
                        <?php if(isset($_GET['layouts']) && in_array("4+kk", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-4kk">4+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-4+1" value="4+1" 
                        <?php if(isset($_GET['layouts']) && in_array("4+1", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-4+1">4+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-5+kk" value="5+kk"
                        <?php if(isset($_GET['layouts']) && in_array("5+kk", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-5+kk">5+kk</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-5+1" value="5+1" 
                        <?php if(isset($_GET['layouts']) && in_array("5+1", $_GET['layouts'])) echo 'checked'; ?>>
                        <label for="layout-5+1">5+1</label>
                    </div>
                </div>

                <!-- Search button -->
                <button type="submit" id="search-button">Search Apartments</button>
                
                
            </form>
        </section>

        <div id="listings-and-pagination">
            <div class="sort-container">
                <label for="sort-select">Sort by:</label>
                <select id="sort-select">
                    <option value="newest" <?php if(isset($_GET['sort']) && $_GET['sort'] === 'newest') echo 'selected'; ?>>Newest</option>
                    <option value="cheap" <?php if(isset($_GET['sort']) && $_GET['sort'] === 'cheap') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="expensive" <?php if(isset($_GET['sort']) && $_GET['sort'] === 'expensive') echo 'selected'; ?>>Price: High to Low</option>
                </select>
            </div>

            <section class="listings">
                <?php print_listings($pdo, $listings); ?>
            </section>

            <?php print_pagination($page, $totalPages); ?>
            </div>
        </div>
    </main>
</body>
</html>

