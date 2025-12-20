<?php
declare(strict_types=1);

// Praha validations
function is_praha_invalid(string $praha): bool {
    $valid_prahas = ['Praha 1', 'Praha 2', 'Praha 3', 'Praha 4', 'Praha 5', 'Praha 6', 'Praha 7', 'Praha 8', 'Praha 9', 'Praha 10'];
    return !in_array($praha, $valid_prahas);
}

// District validations
function is_district_invalid($district, $praha) {
    $valid_districts = [
        'Praha 1' => ['Hradčany', 'Josefov', 'Malá Strana', 'Nové Město', 'Staré Město'],
        'Praha 2' => ['Nusle', 'Vinohrady', 'Vyšehrad'],
        'Praha 3' => ['Žižkov'],
        'Praha 4' => ['Braník', 'Háje', 'Hodkovičky', 'Chodov', 'Cholupice', 'Kamýk', 'Komořany', 'Krč', 'Kunratice', 'Lhotka', 'Libuš', 'Michle', 'Modřany', 'Písnice', 'Podolí', 'Šeberov', 'Točná', 'Újezd', 'Záběhlice'],
        'Praha 5' => ['Hlubočepy', 'Holyně', 'Jinonice', 'Košíře', 'Lahovice', 'Lipence', 'Lochkov', 'Malá Chuchle', 'Motol', 'Radlice', 'Radotín', 'Řeporyje', 'Slivenec', 'Smíchov', 'Sobín', 'Stodůlky', 'Třebonice', 'Velká Chuchle', 'Zadní Kopanina', 'Zbraslav', 'Zličín'],
        'Praha 6' => ['Břevnov', 'Bubeneč', 'Dejvice', 'Liboc', 'Lysolaje', 'Nebušice', 'Přední Kopanina', 'Ruzyně', 'Řepy', 'Sedlec', 'Střešovice', 'Suchdol', 'Veleslavín', 'Vokovice'],
        'Praha 7' => ['Holešovice', 'Troja'],
        'Praha 8' => ['Bohnice', 'Březiněves', 'Čimice', 'Dolní Chabry', 'Ďáblice', 'Karlín', 'Kobylisy', 'Libeň', 'Střížkov'],
        'Praha 9' => ['Běchovice', 'Čakovice', 'Černý Most', 'Dolní Počernice', 'Hloubětín', 'Horní Počernice', 'Hostavice', 'Hrdlořezy', 'Kbely', 'Klánovice', 'Koloděje', 'Kyje', 'Letňany', 'Miškovice', 'Prosek', 'Satalice', 'Třeboradice', 'Újezd nad Lesy', 'Vinoř', 'Vysočany'],
        'Praha 10' => ['Benice', 'Dolní Měcholupy', 'Dubeč', 'Hájek', 'Horní Měcholupy', 'Hostivař', 'Kolovraty', 'Královice', 'Křeslice', 'Lipany', 'Malešice', 'Nedvězí', 'Petrovice', 'Pitkovice', 'Strašnice', 'Štěrboholy', 'Uhříněves', 'Vršovice'],
    ];
    
    return !(isset($valid_districts[$praha]) && in_array($district, $valid_districts[$praha]));
}

// Layout validations
function is_layout_invalid(string $layout): bool {
    $valid_layouts = ['1+kk', '2+kk', '3+kk', '4+kk', '5+kk', '1+1', '2+1', '3+1', '4+1', '5+1'];
    return !in_array($layout, $valid_layouts);
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