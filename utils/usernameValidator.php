<?php

function isUsernameValid($username) {
    return preg_match('/^[a-zA-Z._]{4,}$/', $username);
}