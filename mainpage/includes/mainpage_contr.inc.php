<?php
declare(strict_types = 1);

function isValidPrahaFilter(string $praha): bool {
    $validPraha = [
        '1', '2', '3', '4', '5',
        '6', '7', '8', '9', '10'
    ];
    return in_array($praha, $validPraha, true);
}

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

function isValidPriceFromFilter(string $priceFrom): bool {
    return ctype_digit(trim($priceFrom));
}

function isValidPriceToFilter(string $priceTo): bool {
    return ctype_digit(trim($priceTo));
}

function isValidAreaFromFilter(string $areaFrom): bool {
    return ctype_digit(trim($areaFrom));
}

function isValidAreaToFilter(string $areaTo): bool {
    return ctype_digit(trim($areaTo));
}

function isValidLayoutFilter(string $layout): bool {
    $validLayouts = ['1+kk', '1+1', '2+kk', '2+1', '3+kk', '3+1', '4+kk', '4+1', '5+kk', '5+1'];
    return in_array($layout, $validLayouts, true);
}

function isValidSortByFilter(string $sortBy): bool {
    $validSortBy = ['newest', 'cheap', 'expensive'];
    return in_array($sortBy, $validSortBy, true);
}
