<?php

/**
 * Valide si un mot de passe respecte les critères de sécurité requis
 * 
 * Le mot de passe doit contenir au moins 8 caractères, incluant:
 * - Au moins une lettre majuscule (A-Z)
 * - Au moins une lettre minuscule (a-z)
 * - Au moins un chiffre (0-9)
 * - Au moins un caractère spécial (@$!%*?&)
 * - Uniquement des caractères de ces ensembles
 * 
 * @param string $password Le mot de passe à valider
 * @return bool True si le mot de passe est valide, false sinon
 */
function isPasswordValid($password) {
    return preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password);
}
?>