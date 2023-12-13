// Obtén los valores de los campos de usuario y contraseña
var user = document.getElementsByName("username")[0].value;
var pass = document.getElementsByName("password")[0].value;

// Verifica si ambos campos están vacíos
if (user === "" || pass === "") {
    alert("Ambos campos son obligatorios");
} else if (user.length > 8) {
    alert("El nombre de usuario es muy largo");
    return false;
}





