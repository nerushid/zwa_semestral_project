<?php
declare(strict_types=1);

function print_praha_selection(): void {
    $selected = $_SESSION['newlisting_data']['praha'] ?? '';
    $error = $_SESSION['newlisting_errors']['praha_error'] ?? '';
    $errorClass = $error ? ' error-input' : '';
    
    echo '<!-- Praha selection (1, 2, 3, 4, 5, 6, 7, 8, 9, 10) -->
        <label for="praha-selectid">Choose Praha: <span class="required">*</span></label>
        <select id="praha-selectid" name="praha" class="' . $errorClass . '">
            <option value="">-- select Praha --</option>';

    $prahas = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
    foreach ($prahas as $praha) {
        $isSelected = ($selected === $praha) ? ' selected' : '';
        echo '<option value="' . $praha . '"' . $isSelected . '>Prague ' . $praha . '</option>';
    }
    
    echo '</select>
        <div id="praha-select-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>';
}

function print_district_selection(): void {
    $selected = $_SESSION['newlisting_data']['district'] ?? '';
    $error = $_SESSION['newlisting_errors']['district_error'] ?? '';
    $errorClass = $error ? ' error-input' : '';
    
    $districts = [
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
    
    echo '<!-- District selection -->
        <label for="districtid">District: <span class="required">*</span></label>
        <select name="district" id="districtid" class="' . $errorClass . '">';
    
    foreach ($districts as $praha => $districtList) {
        echo '<optgroup label="' . $praha . '">';
        foreach ($districtList as $district) {
            $isSelected = ($selected === $district) ? ' selected' : '';
            echo '<option value="' . $district . '"' . $isSelected . '>' . $district . '</option>';
        }
        echo '</optgroup>';
    }
    
    echo '</select>
        <div id="district-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>';
}

function print_layout_selection(): void {
    $selected = $_SESSION['newlisting_data']['layout'] ?? '';
    $error = $_SESSION['newlisting_errors']['layout_error'] ?? '';
    $errorClass = $error ? ' error-input' : '';
    
    echo '<!-- Layout selection -->
        <label for="layoutid">Layout: <span class="required">*</span></label>
        <select name="layout" id="layoutid" class="' . $errorClass . '">
            <option value="">-- select layout --</option>';
    
    $layouts = ['1+kk', '2+kk', '3+kk', '4+kk', '5+kk', '1+1', '2+1', '3+1', '4+1', '5+1'];
    foreach ($layouts as $layout) {
        $isSelected = ($selected === $layout) ? ' selected' : '';
        echo '<option value="' . $layout . '"' . $isSelected . '>' . $layout . '</option>';
    }
    
    echo '</select>
        <div id="layout-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>';
}

function print_area_input(): void {
    $value = $_SESSION['newlisting_data']['area'] ?? '';
    $error = $_SESSION['newlisting_errors']['area_error'] ?? '';
    $errorClass = $error ? ' error-input' : '';
    
    echo '<!-- Area selection -->
        <label for="areaid">Area (m²): <span class="required">*</span></label>
        <input type="number" name="area" id="areaid" placeholder="Area in m²" value="' . htmlspecialchars($value) . '" class="' . $errorClass . '">
        <div id="area-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>';
}

function print_price_input(): void {
    $value = $_SESSION['newlisting_data']['price'] ?? '';
    $error = $_SESSION['newlisting_errors']['price_error'] ?? '';
    $errorClass = $error ? ' error-input' : '';
    
    echo '<!-- Price selection -->
        <label for="priceid">Price (CZK): <span class="required">*</span></label>
        <input type="number" name="price" id="priceid" placeholder="Price in CZK" value="' . htmlspecialchars($value) . '" class="' . $errorClass . '">
        <div id="price-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>';
}

function print_description_input(): void {
    $value = $_SESSION['newlisting_data']['description'] ?? '';
    $error = $_SESSION['newlisting_errors']['description_error'] ?? '';
    $errorClass = $error ? ' error-input' : '';
    
    echo '<!-- Description input -->
        <label for="descriptionid">Description: <span class="required">*</span></label>
        <textarea name="description" id="descriptionid" placeholder="Description of the property" class="' . $errorClass . '">' . htmlspecialchars($value) . '</textarea>
        <div id="description-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>';
}

function print_image_input(): void {
    $error = $_SESSION['newlisting_errors']['image_error'] ?? '';
    $errorClass = $error ? ' error-input-file' : '';
    
    echo '<!-- Image upload -->
        <label for="file-upload">Upload Photos (max 10): <span class="required">*</span></label>
        <input
            type="file" 
            id="file-upload" 
            name="listingImages[]" 
            multiple 
            accept="image/*"
            class="' . $errorClass . '"
        >
        <div id="file-upload-errorid" class="error">' . ($error ? '* ' . $error : '') . '</div>
        <div id="preview-container"></div>';
}

function print_newlisting_form(): void {
    print_praha_selection();
    print_district_selection();
    print_layout_selection();
    print_area_input();
    print_price_input();
    print_description_input();
    print_image_input();
    
    unset($_SESSION['newlisting_errors']);
    unset($_SESSION['newlisting_data']);
}


/*
<!-- Praha selection (1, 2, 3, 4, 5, 6, 7, 8, 9, 10) -->
<label for="praha-selectid">Choose Praha: <span class="required">*</span></label>
<select id="praha-selectid" name="praha">
    <option value="">-- select Praha --</option>
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
<div id="praha-select-errorid" class="error"></div>

<!-- District selection -->
<label for="districtid">District: <span class="required">*</span></label>
<select name="district" id="districtid">
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
<div id="district-errorid" class="error"></div>

<!-- Layout selection -->
<label for="layoutid">Layout: <span class="required">*</span></label>
<select name="layout" id="layoutid">
    <option value="">-- select layout --</option>
    <option value="1+kk">1+kk</option>
    <option value="2+kk">2+kk</option>
    <option value="3+kk">3+kk</option>
    <option value="4+kk">4+kk</option>
    <option value="5+kk">5+kk</option>
    <option value="1+1">1+1</option>
    <option value="2+1">2+1</option>
    <option value="3+1">3+1</option>
    <option value="4+1">4+1</option>
    <option value="5+1">5+1</option>
</select>
<div id="layout-errorid" class="error"></div>

<!-- Area selection -->
<label for="areaid">Area (m²): <span class="required">*</span></label>
<input type="number" name="area" id="areaid" placeholder="Area in m²">
<div id="area-errorid" class="error"></div>

<!-- Price selection -->
<label for="priceid">Price (CZK): <span class="required">*</span></label>
<input type="number" name="price" id="priceid" placeholder="Price in CZK">
<div id="price-errorid" class="error"></div>

<!-- Description input -->
<label for="descriptionid">Description: <span class="required">*</span></label>
<textarea name="description" id="descriptionid" placeholder="Description of the property"></textarea>
<div id="description-errorid" class="error"></div>

<!-- Image upload -->
<label for="file-upload">Upload Photos (max 10): <span class="required">*</span></label>
<input
    type="file" 
    id="file-upload" 
    name="listingImages[]" 
    multiple 
    accept="image/*"
>
<div id="file-upload-errorid" class="error"></div>
<div id="preview-container"></div>
*/