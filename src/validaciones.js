function validateForm() {
    // Check if password has 8 or more characters
    var password = document.getElementsByName('password')[0].value;
    if (password.length < 8) {
        alert("La contraseña debe tener al menos 8 caracteres.");
        return false;
    }

    // telefono de 10 digitos
    var telefono = document.getElementsByName('telefono')[0].value;
    if (!/^\d{10}$/.test(telefono)) {
        alert("El número de teléfono debe tener exactamente 10 dígitos numéricos.");
        return false;
    }

    // All validations passed
    return true;
}
function filterNonNumeric(event) {
    const input = event.target;
    const value = input.value;
    const filteredValue = value.replace(/\D/g, ''); // Remove all non-numeric characters
    input.value = filteredValue;
}