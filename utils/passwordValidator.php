<?php

/**
 * Valide si un mot de passe respecte les critères de sécurité requis
 * 
 * Le mot de passe doit contenir au moins 8 caractères, incluant:
 * - Au moins une lettre majuscule (A-Z)
 * - Au moins une lettre minuscule (a-z)
 * - Au moins un chiffre (0-9)
 * 
 * @param string $password Le mot de passe à valider
 * @return bool True si le mot de passe est valide, false sinon
 */
function isPasswordValid($password) {
    return preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $password);
}
?>