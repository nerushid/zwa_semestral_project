<?php
/**
 * Main Page Controller
 * 
 * Contains validation functions for filter parameters.
 * Ensures all user input is validated against allowed values.
 * 
 * @package NestlyHomes\Controllers
 */

declare(strict_types=1);

/**
 * Validates Praha (Prague district) filter value
 * 
 * @param string $praha The Praha value to validate
 * @return bool True if valid Prague district (1-10), false otherwise
 */
function isValidPrahaFilter(string $praha): bool {
    $validPraha = [
        '1', '2', '3', '4', '5',
        '6', '7', '8', '9', '10'
    ];
    return in_array($praha, $validPraha, true);
}

/**
 * Validates district filter against selected Praha
 * 
 * @param string $district The district name to validate
 * @param string $praha The selected Praha district
 * @return bool True if district belongs to Praha, false otherwise
 */
function isValidDistrictFilter(string $district, string $praha): bool {
    $validDistricts = [
        '1' => ['Hradčany', 'Josefov', 'Malá Strana', 'Nové Město', 'Staré Město'],
        '2' => ['Nusle', 'Vinohrady', 'Vyšehrad'],
        '3' => ['Žižkov'],
        '4' => ['Braník', 'Háje', 'Hodkovičky', 'Chodov', 'Cholupice', 'Kamýk', 'Komořany', 'Krč', 'Kunratice', 'Lhotka', 'Libuš', 'Michle', 'Modřany', 'Písnice', 'Podolí', 'Šeberov', 'Točná', 'Újezd', 'Záběhlice'],
        '5' => ['Hlubočepy', 'Holyně', 'Jinonice', 'Košíře', 'Lahovice', 'Lipence', 'Lochkov', 'Malá Chuchle', 'Motol', 'Radlice', 'Radotín', 'Řeporyje', 'Slivenec', 'Smíchov', 'Sobín', 'Stodůlky', 'Třebonice', 'Velká Chuchle', 'Zadní Kopanina', 'Zbraslav', 'Zličín'],
        '6' => ['Břevnov', 'Bubeneč', 'Dejvice', 'Liboc', 'Lysolaje', 'Nebušice', 'Přední Kopanina', 'Ruzyně', 'Řepy', 'Sedlec', 'Střešovice', 'Suchdol', 'Veleslavín', 'Vokovice'],
        '7' => ['Holešovice', 'Troja'],
        '8' => ['Bohnice', 'Březiněves', 'Čimice', 'Dolní Chabry', 'Ďáblice', 'Karlín', 'Kobylisy', 'Libeň', 'Střížkov'],
        '9' => ['Běchovice', 'Čakovice', 'Černý Most', 'Dolní Počernice', 'Hloubětín', 'Horní Počernice', 'Hostavice', 'Hrdlořezy', 'Kbely', 'Klánovice', 'Koloděje', 'Kyje', 'Letňany', 'Miškovice', 'Prosek', 'Satalice', 'Třeboradice', 'Újezd nad Lesy', 'Vinoř', 'Vysočany'],
        '10' => ['Benice', 'Dolní Měcholupy', 'Dubeč', 'Hájek', 'Horní Měcholupy', 'Hostivař', 'Kolovraty', 'Královice', 'Křeslice', 'Lipany', 'Malešice', 'Nedvězí', 'Petrovice', 'Pitkovice', 'Strašnice', 'Štěrboholy', 'Uhříněves', 'Vršovice']
    ];
    return in_array($district, $validDistricts[$praha] ?? [], true);
}

/**
 * Validates price from filter value
 * 
 * @param string $priceFrom The minimum price value
 * @return bool True if valid positive integer, false otherwise
 */
function isValidPriceFromFilter(string $priceFrom): bool {
    return ctype_digit(trim($priceFrom));
}

/**
 * Validates price to filter value
 * 
 * @param string $priceTo The maximum price value
 * @return bool True if valid positive integer, false otherwise
 */
function isValidPriceToFilter(string $priceTo): bool {
    return ctype_digit(trim($priceTo));
}

/**
 * Validates area from filter value
 * 
 * @param string $areaFrom The minimum area value
 * @return bool True if valid positive integer, false otherwise
 */
function isValidAreaFromFilter(string $areaFrom): bool {
    return ctype_digit(trim($areaFrom));
}

/**
 * Validates area to filter value
 * 
 * @param string $areaTo The maximum area value
 * @return bool True if valid positive integer, false otherwise
 */
function isValidAreaToFilter(string $areaTo): bool {
    return ctype_digit(trim($areaTo));
}

/**
 * Validates layout filter value
 * 
 * @param string $layout The layout type to validate
 * @return bool True if valid layout type, false otherwise
 */
function isValidLayoutFilter(string $layout): bool {
    $validLayouts = ['1+kk', '1+1', '2+kk', '2+1', '3+kk', '3+1', '4+kk', '4+1', '5+kk', '5+1'];
    return in_array($layout, $validLayouts, true);
}

/**
 * Validates sort by filter value
 * 
 * @param string $sortBy The sort option to validate
 * @return bool True if valid sort option, false otherwise
 */
function isValidSortByFilter(string $sortBy): bool {
    $validSortBy = ['newest', 'cheap', 'expensive'];
    return in_array($sortBy, $validSortBy, true);
}
