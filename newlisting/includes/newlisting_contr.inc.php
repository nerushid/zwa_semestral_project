<?php
/**
 * New Listing Controller
 * 
 * Contains validation functions for new listing form processing.
 * Validates location, layout, area, price, and description.
 * 
 * @package NestlyHomes
 * @subpackage Controllers
 */

declare(strict_types=1);

// Praha validations
function is_praha_invalid(string $praha): bool {
    $valid_prahas = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
    return !in_array($praha, $valid_prahas);
}

// District validations
function is_district_invalid($district, $praha) {
    $valid_districts = [
        '1' => ['Hradčany', 'Josefov', 'Malá Strana', 'Nové Město', 'Staré Město'],
        '2' => ['Nusle', 'Vinohrady', 'Vyšehrad'],
        '3' => ['Žižkov'],
        '4' => ['Braník', 'Háje', 'Hodkovičky', 'Chodov', 'Cholupice', 'Kamýk', 'Komořany', 'Krč', 'Kunratice', 'Lhotka', 'Libuš', 'Michle', 'Modřany', 'Písnice', 'Podolí', 'Šeberov', 'Točná', 'Újezd', 'Záběhlice'],
        '5' => ['Hlubočepy', 'Holyně', 'Jinonice', 'Košíře', 'Lahovice', 'Lipence', 'Lochkov', 'Malá Chuchle', 'Motol', 'Radlice', 'Radotín', 'Řeporyje', 'Slivenec', 'Smíchov', 'Sobín', 'Stodůlky', 'Třebonice', 'Velká Chuchle', 'Zadní Kopanina', 'Zbraslav', 'Zličín'],
        '6' => ['Břevnov', 'Bubeneč', 'Dejvice', 'Liboc', 'Lysolaje', 'Nebušice', 'Přední Kopanina', 'Ruzyně', 'Řepy', 'Sedlec', 'Střešovice', 'Suchdol', 'Veleslavín', 'Vokovice'],
        '7' => ['Holešovice', 'Troja'],
        '8' => ['Bohnice', 'Březiněves', 'Čimice', 'Dolní Chabry', 'Ďáblice', 'Karlín', 'Kobylisy', 'Libeň', 'Střížkov'],
        '9' => ['Běchovice', 'Čakovice', 'Černý Most', 'Dolní Počernice', 'Hloubětín', 'Horní Počernice', 'Hostavice', 'Hrdlořezy', 'Kbely', 'Klánovice', 'Koloděje', 'Kyje', 'Letňany', 'Miškovice', 'Prosek', 'Satalice', 'Třeboradice', 'Újezd nad Lesy', 'Vinoř', 'Vysočany'],
        '10' => ['Benice', 'Dolní Měcholupy', 'Dubeč', 'Hájek', 'Horní Měcholupy', 'Hostivař', 'Kolovraty', 'Královice', 'Křeslice', 'Lipany', 'Malešice', 'Nedvězí', 'Petrovice', 'Pitkovice', 'Strašnice', 'Štěrboholy', 'Uhříněves', 'Vršovice'],
    ];
    
    return !(isset($valid_districts[$praha]) && in_array($district, $valid_districts[$praha]));
}

// Layout validations
function is_layout_invalid(string $layout): bool {
    $valid_layouts = ['1+kk', '2+kk', '3+kk', '4+kk', '5+kk', '1+1', '2+1', '3+1', '4+1', '5+1'];
    return !in_array($layout, $valid_layouts);
}

// Description validation
function is_description_invalid(string $description): bool {
    // Allow Unicode letters, numbers, spaces, newlines, and common punctuation
    return !preg_match("/^[\p{L}\p{N}\s.,!?;:()\-–—'\"\/]+$/u", $description);
}

// Image upload validations
function is_file_upload_empty(array $files): bool {
    if (isset($files['error'][0]) && $files['error'][0] === UPLOAD_ERR_NO_FILE) {
        return true;
    }
    return false;
}

function is_file_count_invalid(array $files): bool {
    $maxFiles = 10;
    if (isset($files['name']) && count($files['name']) > $maxFiles) {
        return true;
    }
    return false;
}

function is_file_size_too_big(int $fileSize): bool {
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    return $fileSize > $maxFileSize;
}

function is_file_format_invalid(string $tmpName): bool {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($tmpName);

    return !in_array($mimeType, $allowedTypes);
}