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
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
              rows="3">' . htmlspecialchars($value) . '</textarea>';
    } else {
        echo '<input type="text" name="' . $fieldName . '" id="' . $fieldId . '" 
              value="' . htmlspecialchars((string)$value) . '" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">';
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
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
              rows="3">' . htmlspecialchars($subValue) . '</textarea>';
    } else {
        echo '<input type="text" name="' . $fieldName . '" id="' . $fieldId . '" 
              value="' . htmlspecialchars((string)$subValue) . '" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">';
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
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">';
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
          class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 
                 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 
                 focus:ring-offset-2 focus:ring-blue-500">';
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
