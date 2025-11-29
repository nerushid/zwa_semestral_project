<?php
require_once '../includes/config_session.php';
require_once 'includes/mainpage_view.inc.php';
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
    <script src="filter.js" defer></script>
    <script src="layout.js" defer></script>
    <script src="logout.js" defer></script>
</head>

<body>
    <header>
        <p id="nestly-logo">NestlyHomes</p>
        
        <div id="right-side">
            <?php print_header(); ?>
        </div>
    </header>

    <dialog id="logout-dialog">
        <p>Are you sure you want to log out?</p>
        <a href="../includes/logout.inc.php">Yes, Log Out</a>
        <button>Cancel</button>
    </dialog>

    <main>
        <section id="filters-section">

            <form action="#" method="get">
                <h2>Filters</h2>

                <!-- Praha selection -->
                <label for="praha-selectid">Choose Praha:</label>
                <select id="praha-selectid" name="praha">
                    <option value="">Any Praha</option>
                    <option value="Praha 1">Praha 1</option>
                    <option value="Praha 2">Praha 2</option>
                    <option value="Praha 3">Praha 3</option>
                    <option value="Praha 4">Praha 4</option>
                    <option value="Praha 5">Praha 5</option>
                    <option value="Praha 6">Praha 6</option>
                    <option value="Praha 7">Praha 7</option>
                    <option value="Praha 8">Praha 8</option>
                    <option value="Praha 9">Praha 9</option>
                    <option value="Praha 10">Praha 10</option>
                </select>

                <!-- District selection -->
                <label for="districtid">District:</label>
                <select name="district" id="districtid" disabled>
                    <option value="">Any District</option>
                    
                    <optgroup label="Praha 1">
                        <option value="Hradčany">Hradčany</option>
                        <option value="Josefov">Josefov</option>
                        <option value="Malá Strana">Malá Strana</option>
                        <option value="Nové Město">Nové Město</option>
                        <option value="Staré Město">Staré Město</option>
                    </optgroup>

                    <optgroup label="Praha 2">
                        <option value="Nusle">Nusle</option>
                        <option value="Vinohrady">Vinohrady</option>
                        <option value="Vyšehrad">Vyšehrad</option>
                    </optgroup>

                    <optgroup label="Praha 3">
                        <option value="Žižkov">Žižkov</option>
                    </optgroup>

                    <optgroup label="Praha 4">
                        <option value="Braník">Braník</option>
                        <option value="Háje">Háje</option>
                        <option value="Hodkovičky">Hodkovičky</option>
                        <option value="Chodov">Chodov</option>
                        <option value="Cholupice">Cholupice</option>
                        <option value="Kamýk">Kamýk</option>
                        <option value="Komořany">Komořany</option>
                        <option value="Krč">Krč</option>
                        <option value="Kunratice">Kunratice</option>
                        <option value="Lhotka">Lhotka</option>
                        <option value="Libuš">Libuš</option>
                        <option value="Michle">Michle</option>
                        <option value="Modřany">Modřany</option>
                        <option value="Písnice">Písnice</option>
                        <option value="Podolí">Podolí</option>
                        <option value="Šeberov">Šeberov</option>
                        <option value="Točná">Točná</option>
                        <option value="Újezd">Újezd</option>
                        <option value="Záběhlice">Záběhlice</option>
                    </optgroup>

                    <optgroup label="Praha 5">
                        <option value="Hlubočepy">Hlubočepy</option>
                        <option value="Holyně">Holyně</option>
                        <option value="Jinonice">Jinonice</option>
                        <option value="Košíře">Košíře</option>
                        <option value="Lahovice">Lahovice</option>
                        <option value="Lipence">Lipence</option>
                        <option value="Lochkov">Lochkov</option>
                        <option value="Malá Chuchle">Malá Chuchle</option>
                        <option value="Motol">Motol</option>
                        <option value="Radlice">Radlice</option>
                        <option value="Radotín">Radotín</option>
                        <option value="Řeporyje">Řeporyje</option>
                        <option value="Slivenec">Slivenec</option>
                        <option value="Smíchov">Smíchov</option>
                        <option value="Sobín">Sobín</option>
                        <option value="Stodůlky">Stodůlky</option>
                        <option value="Třebonice">Třebonice</option>
                        <option value="Velká Chuchle">Velká Chuchle</option>
                        <option value="Zadní Kopanina">Zadní Kopanina</option>
                        <option value="Zbraslav">Zbraslav</option>
                        <option value="Zličín">Zličín</option>
                    </optgroup>

                    <optgroup label="Praha 6">
                        <option value="Břevnov">Břevnov</option>
                        <option value="Bubeneč">Bubeneč</option>
                        <option value="Dejvice">Dejvice</option>
                        <option value="Liboc">Liboc</option>
                        <option value="Lysolaje">Lysolaje</option>
                        <option value="Nebušice">Nebušice</option>
                        <option value="Přední Kopanina">Přední Kopanina</option>
                        <option value="Ruzyně">Ruzyně</option>
                        <option value="Řepy">Řepy</option>
                        <option value="Sedlec">Sedlec</option>
                        <option value="Střešovice">Střešovice</option>
                        <option value="Suchdol">Suchdol</option>
                        <option value="Veleslavín">Veleslavín</option>
                        <option value="Vokovice">Vokovice</option>
                    </optgroup>

                    <optgroup label="Praha 7">
                        <option value="Holešovice">Holešovice</option>
                        <option value="Troja">Troja</option>
                    </optgroup>

                    <optgroup label="Praha 8">
                        <option value="Bohnice">Bohnice</option>
                        <option value="Březiněves">Březiněves</option>
                        <option value="Čimice">Čimice</option>
                        <option value="Dolní Chabry">Dolní Chabry</option>
                        <option value="Ďáblice">Ďáblice</option>
                        <option value="Karlín">Karlín</option>
                        <option value="Kobylisy">Kobylisy</option>
                        <option value="Libeň">Libeň</option>
                        <option value="Střížkov">Střížkov</option>
                    </optgroup>

                    <optgroup label="Praha 9">
                        <option value="Běchovice">Běchovice</option>
                        <option value="Čakovice">Čakovice</option>
                        <option value="Černý Most">Černý Most</option>
                        <option value="Dolní Počernice">Dolní Počernice</option>
                        <option value="Hloubětín">Hloubětín</option>
                        <option value="Horní Počernice">Horní Počernice</option>
                        <option value="Hostavice">Hostavice</option>
                        <option value="Hrdlořezy">Hrdlořezy</option>
                        <option value="Kbely">Kbely</option>
                        <option value="Klánovice">Klánovice</option>
                        <option value="Koloděje">Koloděje</option>
                        <option value="Kyje">Kyje</option>
                        <option value="Letňany">Letňany</option>
                        <option value="Miškovice">Miškovice</option>
                        <option value="Prosek">Prosek</option>
                        <option value="Satalice">Satalice</option>
                        <option value="Třeboradice">Třeboradice</option>
                        <option value="Újezd nad Lesy">Újezd nad Lesy</option>
                        <option value="Vinoř">Vinoř</option>
                        <option value="Vysočany">Vysočany</option>
                    </optgroup>

                    <optgroup label="Praha 10">
                        <option value="Benice">Benice</option>
                        <option value="Dolní Měcholupy">Dolní Měcholupy</option>
                        <option value="Dubeč">Dubeč</option>
                        <option value="Hájek">Hájek</option>
                        <option value="Horní Měcholupy">Horní Měcholupy</option>
                        <option value="Hostivař">Hostivař</option>
                        <option value="Kolovraty">Kolovraty</option>
                        <option value="Královice">Královice</option>
                        <option value="Křeslice">Křeslice</option>
                        <option value="Lipany">Lipany</option>
                        <option value="Malešice">Malešice</option>
                        <option value="Nedvězí">Nedvězí</option>
                        <option value="Petrovice">Petrovice</option>
                        <option value="Pitkovice">Pitkovice</option>
                        <option value="Strašnice">Strašnice</option>
                        <option value="Štěrboholy">Štěrboholy</option>
                        <option value="Uhříněves">Uhříněves</option>
                        <option value="Vršovice">Vršovice</option>
                    </optgroup>
                </select>

                <!-- Price range selection -->
                <label>Price Range:</label>
                <div class="range-inputs">
                    <div>
                        <label for="price-from"><i>From</i></label>
                        <input type="number" id="price-from" name="price_from" placeholder="0" min="0" step="500">
                    </div>

                    <div>
                        <label for="price-to"><i>To</i></label>
                        <input type="number" id="price-to" name="price_to" placeholder="∞" min="0" step="500">
                    </div>
                </div>

                <!-- Area range selection -->
                <label>Area Range (m²):</label>
                <div class="range-inputs">
                    <div>
                        <label for="area-from"><i>From</i></label>
                        <input type="number" id="area-from" name="area_from" placeholder="0" min="0" step="5">
                    </div>
                    <div>
                        <label for="area-to"><i>To</i></label>
                        <input type="number" id="area-to" name="area_to" placeholder="∞" min="0" step="5">
                    </div>
                </div>

                <!-- Layout selection -->
                <div id="layout-toggle">
                    <label for="layout-toggleid">Choose Layouts</label>
                    <input type="checkbox" name="layout_toggle" id="layout-toggleid">
                </div>

                <div id="layout-checkboxes">
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-1kk" value="1+kk">
                        <label for="layout-1kk">1+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-1+1" value="1+1">
                        <label for="layout-1+1">1+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-2kk" value="2+kk">
                        <label for="layout-2kk">2+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-2+1" value="2+1">
                        <label for="layout-2+1">2+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-3kk" value="3+kk">
                        <label for="layout-3kk">3+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-3+1" value="3+1">
                        <label for="layout-3+1">3+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-4kk" value="4+kk">
                        <label for="layout-4kk">4+kk</label>
                    </div>
                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-4+1" value="4+1">
                        <label for="layout-4+1">4+1</label>
                    </div>

                    <div class="layout-checkbox">
                        <input type="checkbox" name="layouts[]" id="layout-5+" value="5+">
                        <label for="layout-5+">5+ and larger</label>
                    </div>
                </div>
                <!-- Search button -->
                <button type="submit" id="search-button">Search Apartments</button>
                
                
            </form>
        </section>

        <section class="listings">
            <article class="listing-item">
                <a href="#">
                    <img src="appartaments.jpg" alt="apps">
                    <p class="for-rent">Apartment for rent</p>
                    <p class="flat-size">Flat 1+kk, 33 м²</p>
                    <p class="flat-location">Prague 9, Kyje</p>
                    <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
                </a> 
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>

            <article class="listing-item">
                <img src="appartaments.jpg" alt="apps">
                <p class="for-rent">Apartment for rent</p>
                <p class="flat-size">Flat 1+kk, 33 м²</p>
                <p class="flat-location">Prague 9, Kyje</p>
                <p class="flat-cost"><span id="strong">14 000</span> CZK/month</p>
            </article>
        </section>
    </main>
</body>
</html>