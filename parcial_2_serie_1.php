<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gasolinera</title>
</head>
<body>

<h2>Control de Combustible</h2>

<h3>Precios de combustible</h3>

<table border="1">
    <tr>
        <th>Combustible</th>
        <th>Precio</th>
        <th>Subsidio</th>
    </tr>
    <tr>
        <td>Super</td>
        <td>Q32.82</td>
        <td>Q5.00</td>
    </tr>
    <tr>
        <td>Regular</td>
        <td>Q31.57</td>
        <td>Q5.00</td>
    </tr>
    <tr>
        <td>Diesel</td>
        <td>Q29.75</td>
        <td>Q7.00</td>
    </tr>
</table>

<br>

<h3>Registrar venta</h3>

<label>Tipo de combustible:</label>

<select id="combustible">
    <option value="Regular">Regular</option>
    <option value="Diesel">Diesel</option>
    <option value="Super">Super</option>
</select>

<br><br>

<label>Galones vendidos:</label>
<input type="number" id="galones">

<br><br>

<button onclick="guardarVenta()">Guardar venta</button>

<hr>

<h2>Ventas del día</h2>

<p>Regular: Q<span id="totalRegular">0.00</span></p>
<p>Diesel: Q<span id="totalDiesel">0.00</span></p>
<p>Super: Q<span id="totalSuper">0.00</span></p>

<h3>Total general: Q<span id="totalGeneral">0.00</span></h3>

<p>Galones subsidiados: <span id="galonesSubsidiados">0</span></p>

<button onclick="borrarVentas()">Borrar ventas del día</button>

<script>

function guardarVenta() {

    let combustible = document.getElementById("combustible").value;
    let galones = Number(document.getElementById("galones").value);

    let precio = 0;
    let subsidio = 0;

    if (combustible == "Super") {
        precio = 32.82;
        subsidio = 5;
    }

    if (combustible == "Regular") {
        precio = 31.57;
        subsidio = 5;
    }

    if (combustible == "Diesel") {
        precio = 29.75;
        subsidio = 7;
    }

    if (galones <= 100) {
        precio = precio - subsidio;
    }

    let totalVenta = galones * precio;

    let ventas = JSON.parse(localStorage.getItem("ventas")) || [];

    let nuevaVenta = {
        combustible: combustible,
        galones: galones,
        total: totalVenta
    };

    ventas.push(nuevaVenta);

    localStorage.setItem("ventas", JSON.stringify(ventas));

    mostrarVentas();
}


function mostrarVentas() {

    let ventas = JSON.parse(localStorage.getItem("ventas")) || [];

    let regular = 0;
    let diesel = 0;
    let superTotal = 0;
    let subsidiados = 0;

    for (let venta of ventas) {

        if (venta.combustible == "Regular") {
            regular += venta.total;
        }

        if (venta.combustible == "Diesel") {
            diesel += venta.total;
        }

        if (venta.combustible == "Super") {
            superTotal += venta.total;
        }

        if (venta.galones <= 100) {
            subsidiados += venta.galones;
        }
    }

    let general = regular + diesel + superTotal;

    document.getElementById("totalRegular").innerText = regular.toFixed(2);
    document.getElementById("totalDiesel").innerText = diesel.toFixed(2);
    document.getElementById("totalSuper").innerText = superTotal.toFixed(2);
    document.getElementById("totalGeneral").innerText = general.toFixed(2);
    document.getElementById("galonesSubsidiados").innerText = subsidiados;
}


function borrarVentas() {

    localStorage.removeItem("ventas");

    mostrarVentas();
}


mostrarVentas();

</script>

</body>
</html>