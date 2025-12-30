<?php
declare(strict_types=1);

function print_inputs(array $listing): void {
    $data = $_SESSION['editlisting_data'] ?? $listing;
    $errors = $_SESSION['editlisting_errors'] ?? [];

    // Praha selection
    $prahaValue = $data['praha'] ?? '';
    $prahaError = $errors['praha_error'] ?? '';
    $prahaClass = $prahaError ? ' error-input' : '';
    
    echo '<div class="form-group">
            <label for="praha">Prague District</label>
            <select id="praha" name="praha" class="' . $prahaClass . '">
                <option value="">Select Praha</option>';
    for ($i = 1; $i <= 10; $i++) {
        $selected = ($prahaValue == $i) ? ' selected' : '';
        echo '<option value="' . $i . '"' . $selected . '>Praha ' . $i . '</option>';
    }
    echo '</select>
            <div class="error">' . ($prahaError ? '* ' . $prahaError : '') . '</div>
          </div>';

    // District selection
    $districtValue = $data['district'] ?? '';
    $districtError = $errors['district_error'] ?? '';
    $districtClass = $districtError ? ' error-input' : '';
    $districtDisabled = empty($prahaValue) ? ' disabled' : '';
    
    echo '<div class="form-group">
            <label for="district">Specific District</label>
            <select id="district" name="district" class="' . $districtClass . '"' . $districtDisabled . '>
                <option value="">Select District</option>';
    
    // Include all districts grouped by Praha
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
        '10' => ['Benice', 'Dolní Měcholupy', 'Dubeč', 'Hájek', 'Horní Měcholupy', 'Hostivař', 'Kolovraty', 'Královice', 'Křeslice', 'Lipany', 'Malešice', 'Nedvězí', 'Petrovice', 'Pitkovice', 'Strašnice', 'Štěrboholy', 'Uhříněves', 'Vršovice']
    ];
    
    foreach ($districts as $prahaNum => $districtList) {
        echo '<optgroup label="' . $prahaNum . '">';
        foreach ($districtList as $dist) {
            $selected = ($districtValue === $dist) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($dist) . '"' . $selected . '>' . htmlspecialchars($dist) . '</option>';
        }
        echo '</optgroup>';
    }
    
    echo '</select>
            <div class="error">' . ($districtError ? '* ' . $districtError : '') . '</div>
          </div>';

    // Layout
    $layoutValue = $data['layout'] ?? '';
    $layoutError = $errors['layout_error'] ?? '';
    $layoutClass = $layoutError ? ' error-input' : '';
    
    echo '<div class="form-group">
            <label for="layout">Layout</label>
            <select id="layout" name="layout" class="' . $layoutClass . '">
                <option value="">Select Layout</option>';
    $layouts = ['1+kk', '1+1', '2+kk', '2+1', '3+kk', '3+1', '4+kk', '4+1', '5+kk', '5+1'];
    foreach ($layouts as $layout) {
        $selected = ($layoutValue === $layout) ? ' selected' : '';
        echo '<option value="' . $layout . '"' . $selected . '>' . $layout . '</option>';
    }
    echo '</select>
            <div class="error">' . ($layoutError ? '* ' . $layoutError : '') . '</div>
          </div>';

    // Area
    $areaValue = $data['area'] ?? '';
    $areaError = $errors['area_error'] ?? '';
    $areaClass = $areaError ? ' error-input' : '';
    
    echo '<div class="form-group">
            <label for="area">Area (m²)</label>
            <input type="number" id="area" name="area" placeholder="Enter area in m²" 
                   value="' . htmlspecialchars((string)$areaValue) . '" class="' . $areaClass . '">
            <div class="error">' . ($areaError ? '* ' . $areaError : '') . '</div>
          </div>';

    // Price
    $priceValue = $data['price'] ?? '';
    $priceError = $errors['price_error'] ?? '';
    $priceClass = $priceError ? ' error-input' : '';
    
    echo '<div class="form-group">
            <label for="price">Price (CZK/month)</label>
            <input type="number" id="price" name="price" placeholder="Enter monthly rent" 
                   value="' . htmlspecialchars((string)$priceValue) . '" class="' . $priceClass . '">
            <div class="error">' . ($priceError ? '* ' . $priceError : '') . '</div>
          </div>';

    // Description
    $descriptionValue = $data['listing_description'] ?? '';
    $descriptionError = $errors['description_error'] ?? '';
    $descriptionClass = $descriptionError ? ' error-input' : '';
    
    echo '<div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="6" 
                      placeholder="Describe your apartment..." class="' . $descriptionClass . '">' 
            . htmlspecialchars($descriptionValue) . '</textarea>
            <div class="error">' . ($descriptionError ? '* ' . $descriptionError : '') . '</div>
          </div>';

    echo '<div class="error" id="csrf-error">' . htmlspecialchars($errors['csrf_error'] ?? '') . '</div>';

    unset($_SESSION['editlisting_errors']);
    unset($_SESSION['editlisting_data']);
}
        