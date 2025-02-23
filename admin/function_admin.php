<?php

/**
 * Met à jour récursivement les données d'un tableau
 * 
 * @param array $original Données originales
 * @param array $new Nouvelles données
 * @return array Données mises à jour
 */
function updateData($original, $new) {
    foreach ($new as $key => $value) {
        if (is_array($value) && isset($original[$key]) && is_array($original[$key])) {
            $original[$key] = updateData($original[$key], $value);
        } else {
            $original[$key] = $value;
        }
    }
    return $original;
}

/**
 * Génère les champs de formulaire de manière récursive
 * 
 * @param array $data Données à afficher
 * @param string $prefix Préfixe pour les noms de champs
 */
function generateFormFields($data, $prefix = '') {
    foreach ($data as $key => $value) {
        if ($key === 'seo') {
            echo '<div class="bg-gray-50 p-4 rounded-lg mb-6">';
            echo '<h3 class="text-lg font-medium text-gray-900 mb-4">SEO</h3>';
            generateFormFields($value, 'seo');
            echo '</div>';
            continue;
        }

        if (is_array($value)) {
            if (isset($value[0])) { // C'est un tableau numérique
                generateArrayField($key, $value, $prefix);
            } else {
                generateObjectField($key, $value, $prefix);
            }
        } else {
            generateSimpleField($key, $value, $prefix);
        }
    }
}

/**
 * Génère un champ pour un tableau d'éléments
 */
function generateArrayField($key, $value, $prefix) {
    echo '<div class="border p-4 rounded-lg mb-4">';
    echo '<h3 class="text-lg font-medium mb-2">' . ucfirst($key) . '</h3>';
    echo '<div id="' . $key . 'Container" class="space-y-4">';
    
    foreach ($value as $index => $item) {
        echo '<div class="flex gap-4 items-start">';
        if (is_array($item)) {
            foreach ($item as $subKey => $subValue) {
                generateArrayItemField($key, $index, $subKey, $subValue, $prefix);
            }
        } else {
            generateSimpleArrayItemField($key, $item, $prefix);
        }
        generateDeleteButton();
        echo '</div>';
    }
    
    echo '</div>';
    generateAddButton($key);
    echo '</div>';
}

/**
 * Génère un champ pour un objet
 */
function generateObjectField($key, $value, $prefix) {
    echo '<div class="mb-4">';
    echo '<h3 class="text-lg font-medium mb-2">' . ucfirst($key) . '</h3>';
    echo '<div class="space-y-4">';
    generateFormFields($value, $prefix ? "{$prefix}[{$key}]" : $key);
    echo '</div>';
    echo '</div>';
}

/**
 * Génère un champ simple
 */
function generateSimpleField($key, $value, $prefix) {
    $fieldName = $prefix ? "{$prefix}[{$key}]" : $key;
    $fieldId = str_replace(['[', ']'], '_', $fieldName);
    
    echo '<div class="mb-4">';
    echo '<label for="' . $fieldId . '" class="block text-sm font-medium text-gray-700">' . ucfirst($key) . '</label>';
    
    if (is_string($value) && strlen($value) > 100) {
        echo '<textarea name="' . $fieldName . '" id="' . $fieldId . '" 
              class="w-full px-4 py-2 rounded-lg border border-gray-300" 
              rows="3">' . htmlspecialchars($value) . '</textarea>';
    } else {
        echo '<input type="text" name="' . $fieldName . '" id="' . $fieldId . '" 
              value="' . htmlspecialchars((string)$value) . '" 
              class="w-full px-4 py-2 rounded-lg border border-gray-300">';
    }
    
    echo '</div>';
}

/**
 * Génère un champ pour un élément de tableau
 */
function generateArrayItemField($key, $index, $subKey, $subValue, $prefix) {
    $fieldName = $prefix ? "{$prefix}[{$key}][{$index}][{$subKey}]" : "{$key}[{$index}][{$subKey}]";
    $fieldId = str_replace(['[', ']'], '_', $fieldName);
    
    echo '<div class="flex-1">';
    echo '<label class="block text-sm font-medium text-gray-700">' . ucfirst($subKey) . '</label>';
    
    if (is_string($subValue) && strlen($subValue) > 100) {
        echo '<textarea name="' . $fieldName . '" id="' . $fieldId . '" 
              class="w-full px-4 py-2 rounded-lg border border-gray-300" 
              rows="3">' . htmlspecialchars($subValue) . '</textarea>';
    } else {
        echo '<input type="text" name="' . $fieldName . '" id="' . $fieldId . '" 
              value="' . htmlspecialchars((string)$subValue) . '" 
              class="w-full px-4 py-2 rounded-lg border border-gray-300">';
    }
    
    echo '</div>';
}

/**
 * Génère un champ simple pour un élément de tableau
 */
function generateSimpleArrayItemField($key, $item, $prefix) {
    $fieldName = $prefix ? "{$prefix}[{$key}][]" : "{$key}[]";
    echo '<input type="text" name="' . $fieldName . '" 
          value="' . htmlspecialchars((string)$item) . '" 
          class="w-full px-4 py-2 rounded-lg border border-gray-300">';
}

/**
 * Génère le bouton de suppression
 */
function generateDeleteButton() {
    echo '<button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">';
    echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>';
    echo '</button>';
}

/**
 * Génère le bouton d'ajout
 */
function generateAddButton($key) {
    echo '<button type="button" onclick="addItem(\'' . $key . '\')" 
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition-colors">';
    echo 'Ajouter ' . rtrim(ucfirst($key), 's');
    echo '</button>';
} 

/**
  *	[DEBUG] Fonction _d()
  * 	== print_r
  */
  function _d($d) {
	echo '<hr><pre style="margin:20px;text-align:left;background:#e7e1ff;padding:20px;font-size:14px;">';
	print_r($d);
	echo '</pre><hr>';
}

/**
 * Génère les champs SEO
 */
function generateSeoFields($seoData = []) {
    $defaultSeo = [
        'title' => '',
        'description' => '',
        'keywords' => '',
        'image' => '',
        'robots' => 'index, follow',
        'canonical' => ''
    ];
    
    $seoData = array_merge($defaultSeo, $seoData);
    ?>
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">SEO</h3>
            <button type="button" class="text-sm text-blue-500 hover:text-blue-700" onclick="previewSEO()">
                Prévisualiser
            </button>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Titre de la page
                    <span class="text-sm text-gray-500">(50-60 caractères)</span>
                </label>
                <input type="text" name="seo[title]" 
                    value="<?php echo htmlspecialchars($seoData['title']); ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300"
                    onkeyup="countCharacters(this, 60)">
                <div class="text-sm text-gray-500 mt-1">
                    <span class="character-count">0</span>/60 caractères
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Description
                    <span class="text-sm text-gray-500">(150-160 caractères)</span>
                </label>
                <textarea name="seo[description]" rows="3" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300"
                    onkeyup="countCharacters(this, 160)"><?php echo htmlspecialchars($seoData['description']); ?></textarea>
                <div class="text-sm text-gray-500 mt-1">
                    <span class="character-count">0</span>/160 caractères
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mots-clés</label>
                <input type="text" name="seo[keywords]" 
                    value="<?php echo htmlspecialchars($seoData['keywords']); ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300"
                    placeholder="mot-clé1, mot-clé2, mot-clé3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Image de partage</label>
                <div class="flex gap-2">
                    <input type="text" name="seo[image]" 
                        value="<?php echo htmlspecialchars($seoData['image']); ?>"
                        class="flex-1 px-4 py-2 rounded-lg border border-gray-300">
                    <button type="button" onclick="openMediaLibrary('seo[image]')"
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
                        Choisir
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">URL canonique</label>
                <input type="text" name="seo[canonical]" 
                    value="<?php echo htmlspecialchars($seoData['canonical']); ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300"
                    placeholder="https://votresite.com/page">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Indexation</label>
                <select name="seo[robots]" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300">
                    <option value="index, follow" <?php echo $seoData['robots'] === 'index, follow' ? 'selected' : ''; ?>>
                        Indexer et suivre
                    </option>
                    <option value="noindex, follow" <?php echo $seoData['robots'] === 'noindex, follow' ? 'selected' : ''; ?>>
                        Ne pas indexer mais suivre
                    </option>
                    <option value="noindex, nofollow" <?php echo $seoData['robots'] === 'noindex, nofollow' ? 'selected' : ''; ?>>
                        Ne pas indexer et ne pas suivre
                    </option>
                </select>
            </div>
        </div>
    </div>

    <!-- Prévisualisation SEO Modal -->
    <div id="seoPreviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full">
            <h3 class="text-lg font-medium mb-4">Prévisualisation SEO</h3>
            <div class="space-y-4">
                <div class="border p-4 rounded">
                    <div class="text-blue-600 text-xl mb-1" id="previewTitle"></div>
                    <div class="text-green-700 text-sm mb-2" id="previewUrl"></div>
                    <div class="text-gray-600" id="previewDescription"></div>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeSEOPreview()" 
                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Fermer
                </button>
            </div>
        </div>
    </div>
    <?php
}
