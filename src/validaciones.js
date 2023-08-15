function validateForm() {
    // Check if password has 8 or more characters
    var password = document.getElementsByName('password')[0].value;
    if (password.length < 8) {
        alert("La contraseña debe tener al menos 8 caracteres.");
        return false;
    }

    // Check if phone number has 10 digits
    var telefono = document.getElementsByName('telefono')[0].value;
    if (!/^\d{10}$/.test(telefono)) {
        alert("El número de teléfono debe tener exactamente 10 dígitos numéricos.");
        return false;
    }

    // All validations passed
    return true;
}