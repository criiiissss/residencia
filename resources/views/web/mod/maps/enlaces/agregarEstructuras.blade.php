@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <h1>Agregar Estructuras al Enlace {{ $enlace->name }}</h1>
        <div id="map" style="height: 500px; width: 100%;"></div>

        <!-- Campo para subir el archivo Excel -->
        <div>
            <label for="archivoExcel">Subir archivo Excel:</label>
            <input type="file" id="archivoExcel" accept=".xls, .xlsx">
            <button type="button" onclick="leerExcel()">Procesar Excel</button>
        </div>

        <!-- Formulario para guardar las estructuras -->
        <form id="formEstructuras" action="{{ route('estructura-agregar', $enlace->id) }}" method="POST">
                @csrf
            <table id="tablaEstructuras">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Tipo</th>
                        <th>Distancia (km)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas se generan dinámicamente con JavaScript -->
                </tbody>
            </table>
            <button type="submit">Guardar Estructuras</button>
        </form>
    </div>
</div>

<!-- Incluir la librería SheetJS para leer archivos Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

<script>
    let map;
    let markers = [];
    let coordenadas = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 17.163562646405808, lng: -94.92223315372371 },
            zoom: 7
        });

        map.addListener('click', function(event) {
            agregarMarcador(event.latLng);
        });
    }

    function agregarMarcador(latLng) {
        const marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
        markers.push(marker);
        coordenadas.push({ lat: latLng.lat(), lng: latLng.lng() });
        agregarFila(latLng.lat(), latLng.lng());
    }

    function agregarFila(lat = '', lng = '', nombre = '', tipo = 'no', distancia = '', index) {
    console.log("Agregando fila:", index, nombre, lat, lng, tipo, distancia); // Depuración

    const tbody = document.getElementById('tablaEstructuras').getElementsByTagName('tbody')[0];
    const newRow = tbody.insertRow(); // Agrega una nueva fila al final de la tabla

    newRow.innerHTML = `
        <td><input type="text" name="estructuras[${index}][name]" value="${nombre}" required></td>
        <td><input type="text" name="estructuras[${index}][lat]" value="${lat}" required></td>
        <td><input type="text" name="estructuras[${index}][lng]" value="${lng}" required></td>
        <td>
            <select name="estructuras[${index}][tipo]">
                <option value="si" ${tipo === 'si' ? 'selected' : ''}>Caja de Empalme</option>
                <option value="no" ${tipo === 'no' ? 'selected' : ''}>Torre</option>
            </select>   
        </td>
        <td><input type="number" name="estructuras[${index}][distancia]" value="${distancia}" step="0.01" required></td>
    `;
    }


    function leerExcel() {
    const archivo = document.getElementById('archivoExcel').files[0];
    if (!archivo) {
        alert('Por favor, selecciona un archivo Excel.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });
        const primeraHoja = workbook.Sheets[workbook.SheetNames[0]];
        const json = XLSX.utils.sheet_to_json(primeraHoja);

        console.log("Contenido del Excel:", json); // Verificar que los datos sean correctos

        // Limpiar la tabla antes de agregar nuevos datos
        const tbody = document.getElementById('tablaEstructuras').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';

        // Agregar filas con los datos del Excel
        json.forEach((fila, index) => {
            const nombre = fila['nombre'] || '';  
            const latitud = fila['latitud'] || '';  
            const longitud = fila['longitud'] || '';  
            const tipo = fila['tipo'] || 'no';  
            const distancia = fila['distacia anterior'] || '';  

            console.log(`Fila ${index + 1}:`, nombre, latitud, longitud, tipo, distancia); // Depuración

            // Agregar la fila en la tabla
            agregarFila(latitud, longitud, nombre, tipo, distancia, index);
            });
        };
    reader.readAsArrayBuffer(archivo);
    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap" async defer></script>
@endsection