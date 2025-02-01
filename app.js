// Tu configuración de Firebase
const firebaseConfig = {
    apiKey: "AIzaSyC_QCPIELUw5GlXFJ0_W3JPh1ngV-coOkw",
    authDomain: "streamingcontrol-4e2a9.firebaseapp.com",
    databaseURL: "https://streamingcontrol-4e2a9-default-rtdb.firebaseio.com",
    projectId: "streamingcontrol-4e2a9",
    storageBucket: "streamingcontrol-4e2a9.firebasestorage.app",
    messagingSenderId: "405239982323",
    appId: "1:405239982323:web:eac53ca97a9b61f16def86",
    measurementId: "G-72HZC8N611"
  };
  
  // Inicializa Firebase
  firebase.initializeApp(firebaseConfig);
  const database = firebase.database();
  
  // Función para agregar una cuenta de streaming a la base de datos
  function agregarCuenta(plataforma, cuenta, tipo, fechaInicio, fechaRenovacion, precioMensual) {
    const cuentaRef = database.ref('cuentas/' + plataforma + '/' + cuenta); // Crea una referencia a la ruta
  
    // Guarda los datos de la cuenta en Firebase
    cuentaRef.set({
      plataforma: plataforma,
      cuenta: cuenta,
      tipo: tipo,
      fecha_inicio: fechaInicio,
      fecha_renovacion: fechaRenovacion,
      precio_mensual: precioMensual,
      estado: 'Activa'
    }).then(() => {
      console.log("Cuenta añadida correctamente.");
      obtenerCuentas(); // Actualiza la lista de cuentas después de agregar una nueva
    }).catch((error) => {
      console.error("Error al añadir cuenta: ", error);
    });
  }
  
  // Función para obtener y mostrar todas las cuentas de streaming
  function obtenerCuentas() {
    const dbRef = database.ref();
    dbRef.child('cuentas/').get().then((snapshot) => {
      if (snapshot.exists()) {
        const cuentas = snapshot.val();
        mostrarCuentas(cuentas);  // Llama a la función para mostrar los datos en la interfaz
      } else {
        console.log("No hay datos disponibles.");
      }
    }).catch((error) => {
      console.error("Error al obtener los datos: ", error);
    });
  }
  
  // Función para mostrar las cuentas en la tabla
  function mostrarCuentas(cuentas) {
    const tabla = document.getElementById('tabla-cuentas').getElementsByTagName('tbody')[0];
    tabla.innerHTML = '';  // Limpiar la tabla
  
    for (const plataforma in cuentas) {
      for (const cuenta in cuentas[plataforma]) {
        const datosCuenta = cuentas[plataforma][cuenta];
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${datosCuenta.plataforma}</td>
          <td>${datosCuenta.cuenta}</td>
          <td>${datosCuenta.tipo}</td>
          <td>${datosCuenta.fecha_inicio}</td>
          <td>${datosCuenta.fecha_renovacion}</td>
          <td>${datosCuenta.precio_mensual}</td>
          <td>${datosCuenta.estado}</td>
        `;
        tabla.appendChild(fila);
      }
    }
  }
  
  // Manejo de envío del formulario
  document.getElementById('form-cuenta').addEventListener('submit', function(event) {
    event.preventDefault();
  
    const plataforma = document.getElementById('plataforma').value;
    const cuenta = document.getElementById('cuenta').value;
    const tipo = document.getElementById('tipo').value;
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaRenovacion = document.getElementById('fecha_renovacion').value;
    const precioMensual = document.getElementById('precio_mensual').value;
  
    // Llama a la función para agregar la cuenta
    agregarCuenta(plataforma, cuenta, tipo, fechaInicio, fechaRenovacion, precioMensual);
  });
  
  // Obtener las cuentas al cargar la página
  window.onload = obtenerCuentas;  