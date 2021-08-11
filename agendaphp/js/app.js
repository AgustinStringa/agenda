//se utiliza la "nueva" sintaxis de javascript, los query selector

const DIV_FORMULARIO = document.querySelector('#contacto');
const listadoContactos = document.querySelector('#listado-contactos tbody');
const inputBuscador = document.querySelector('#buscar');

const trPlaceholder = document.querySelector('#tr-placeholder');



eventListeners();

function eventListeners() {
    DIV_FORMULARIO.addEventListener('submit', readForm);

    if (listadoContactos) {
        //escuchador para eliminar contato
        listadoContactos.addEventListener('click', eliminarContacto);
    }

    /**
     * event listener para el buscador
     */

    if (inputBuscador) {
        inputBuscador.addEventListener('input', buscarContactos);
    }
    numeroContactos();
}

function readForm(e) {
    e.preventDefault();

    const NOMBRE = document.querySelector('#nombre').value;
    const EMPRESA = document.querySelector('#empresa').value;
    const TELEFONO = document.querySelector('#telefono').value;
    const ACCION = document.querySelector('#accion').value;



    if (NOMBRE === '', EMPRESA === '', TELEFONO === '') {
        mostrarNotificacion("No todos los campos están completos", "error");

        /***
         * mensaje de validacion, codigo escrito por mi
         * funciona con algunos componentes comentados en formulario.php
         * y styles.css
         */
        // var mensajeValidacion = document.querySelector('#mensajeValidacion');
        // mensajeValidacion.style.display = "block";
    } else {


        //validacion aprobada, enviar ajax
        const INFO_CONTACTO = new FormData();
        INFO_CONTACTO.append('nombre', NOMBRE);
        INFO_CONTACTO.append('empresa', EMPRESA);
        INFO_CONTACTO.append('telefono', TELEFONO);
        INFO_CONTACTO.append('accion', ACCION);

        // console.log(...INFO_CONTACTO);

        if (ACCION === "crear") {

            insertDB(INFO_CONTACTO);

        } else if (ACCION === "editar") {
            /***
             * editando del contacto
             */

            const idRegistro = document.querySelector('#id').value;
            INFO_CONTACTO.append('idRegistro', idRegistro);
            //console.log(...INFO_CONTACTO);
            actualizarRegistro(INFO_CONTACTO);
            /**
             * este id de registro se usa para ejecutar una consulta ALTER TABLE
             * 
             */

        }
    }
};


//NOTIFICACION VALIDACION FORMULARIO CONTACTO

//la funcion recibe dos parametros para que sea reutilizada y mostrar diferentes notificaciones dependiendo
/***
 * de la situacion
 */
const NOTIFICACION = document.createElement('div');


function mostrarNotificacion(mensaje, clase) {
    NOTIFICACION.classList.remove('exito');
    NOTIFICACION.classList.remove('error');
    NOTIFICACION.classList.add(clase, 'notificacion', 'sombra');
    NOTIFICACION.textContent = mensaje;

    DIV_FORMULARIO.insertBefore(NOTIFICACION, document.querySelector('#contacto legend'));

    setTimeout(() => {
        NOTIFICACION.classList.add('visible');

        setTimeout(() => {
            NOTIFICACION.classList.remove('visible');
            setTimeout(() => {
                NOTIFICACION.remove();
            }, 5000);
        }, 3000);

    }, 100);
}


/*DECLARACION INSERTAR DB*/
function insertDB(datos) {

    //estos datos que recibe son los de INFO_CONTACTO

    //llamado a AJAX

    //crear objeto
    const XHR = new XMLHttpRequest();
    //abrir conexion
    XHR.open("POST", "inc/modelos/modelo-contacto.php", true);
    //pasar datos}



    XHR.onload = function() {

        if (this.status === 200) {

            // console.log(JSON.parse(XHR.responseText));
            const RESPUESTA = JSON.parse(XHR.responseText);
            console.log(RESPUESTA);
            console.log(RESPUESTA.datos.nombre);

            /***
             * creando nuevo contacto en base a la respuesta del XML
             */
            const nuevoContacto = document.createElement('tr');

            nuevoContacto.innerHTML = `
                <td>${RESPUESTA.datos.nombre}</td>
                <td>${RESPUESTA.datos.empresa}</td>
                <td>${RESPUESTA.datos.telefono}</td>
            `;


            /***
             * crear contenedor paraa botones
             */

            const contenedorBotones = document.createElement('td');

            /**
             * crear icono y boton editar
             */
            const iconoEditar = document.createElement('i');
            iconoEditar.classList.add('fas', 'fa-pen-square');
            const btnEditar = document.createElement('a');
            btnEditar.appendChild(iconoEditar);
            btnEditar.href = `editar_contacto.php?id=${RESPUESTA.datos.id_insertado}`;
            btnEditar.classList.add('btn', 'btnEditar');



            /**
             * crear icono y boton cesto de basura
             */
            const iconoCestoBasura = document.createElement('i');
            iconoCestoBasura.classList.add('fas', 'fa-trash-alt');
            const btnCestoBasura = document.createElement('button');
            btnCestoBasura.appendChild(iconoCestoBasura);
            btnCestoBasura.setAttribute('data-id', RESPUESTA.datos.id_insertado);
            btnCestoBasura.classList.add('btn', 'btnBorrar');



            /***
             * agregando al contenedor <td> los botones
             * 
             */
            contenedorBotones.appendChild(btnEditar);
            contenedorBotones.appendChild(btnCestoBasura);

            /****
             * agregando el contenedor al <tr>
             */
            nuevoContacto.appendChild(contenedorBotones);

            /***
             * agregando el tr al tbody
             */
            listadoContactos.appendChild(nuevoContacto);

            /***
             * reiniciar el formulario
             */
            document.querySelector('form').reset();
            /***
             * mostrar notificacion
             */
            mostrarNotificacion("Contacto agregado exitosamente", "exito");
            /**
             * actualizar numero
             */

            numeroContactos();
        }
    }


    XHR.send(datos);
    //leer errores
}


/**DECLARACION FUNCION eliminarContacto */

function eliminarContacto(e) {
    //(e.target.parentElement.classList.contains('btnBorrar')); //e.target devuelve el nodo en el que se hizo click

    if (e.target.parentElement.classList.contains('btnBorrar')) {
        var id_elemento = e.target.parentElement.getAttribute("data-id"); //se obtiene el atributo desde el valor en el atributo del elemento <button>
        var nombre_elemento = e.target.parentElement.parentElement.parentElement.firstElementChild.textContent;


        console.log(nombre_elemento);
        console.log(id_elemento);

        /*confirmacion del usuario*/

        const confirmacion = confirm(`¿Desea realmente eliminar el contacto -> ${nombre_elemento} ?`);

        if (confirmacion) {

            //llamar AJAX
            //crear objeto
            const XHR = new XMLHttpRequest();
            //abrir conexion
            /**
             * en este caso se usa el METODO GET, ya que se van a obtener valores de la DB
             * los datos necesarios para la operación se envían en la URL
             * en el caso de POST se envían desde .send()
             */
            XHR.open("GET", `inc/modelos/modelo-contacto.php?id=${id_elemento}&accion=borrar`, true);
            //pasar datos

            XHR.onload = function() {
                if (this.status == 200) {
                    const resultado = JSON.parse(XHR.responseText);
                    console.log(resultado);

                    if (resultado.respuesta === 'correcto') {
                        console.log('se va a eliminar del DOM');
                        //eliminar elemento
                        e.target.parentElement.parentElement.parentElement.remove();
                        mostrarNotificacion('Contacto eliminado exitosamente', 'exito');
                        /**
                         * actualizar numero de registros
                         * 
                         */

                        numeroContactos();

                    } else {
                        mostrarNotificacion('Hubo un error...', 'error');
                    }
                }
            };

            XHR.send();
            //leer errores


        } else {
            console.log('no broder');
        }

    }

}

/***DECLARACION METODO PARA MODIFICAR EL REGISTRO EN LA DB */

function actualizarRegistro(datos) {
    console.log(...datos);

    const XHR = new XMLHttpRequest();

    XHR.open('POST', 'inc/modelos/modelo-contacto.php', true);

    XHR.onload = function() {
        if (this.status == 200) {
            const RESP = JSON.parse(XHR.responseText);
            if (RESP.respuesta == "correcto") {

                mostrarNotificacion('contacto modificado exitosamente', 'exito');

            } else {
                mostrarNotificacion('hubo un error...');
            }
            /**despues de 3segundos redireccionar */
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 3000);
        }
    }

    XHR.send(datos);
}

/**funcion buscar contactos */

function buscarContactos(e) {
    /**Este evento devuelve como String lo que haya en el input */
    const registros = document.querySelectorAll('tbody tr');
    //console.log(registros);
    const expresion = new RegExp(e.target.value, "i");
    /*i ignora mayus*/

    registros.forEach(registro => {
        //console.log(registro.childNodes[1]);
        /**childNodes[1] devuelve el primer elemento "hijo" */
        /**aplicado a cada "registro" como en este caso, devuelve el primer td de cada tr */
        /**si se usase [3] o [5] se alternaria entre los demas nodos hijos */
        //console.log(registro.childNodes[1].textContent);
        registro.style.display = "none";
        if (registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1) {
            registro.style.display = "table-row";

        }
        numeroContactos();
    })
}


/**function para los numeros */

function numeroContactos() {
    const totalContactos = document.querySelectorAll('tbody tr');
    const contenedorNumero = document.querySelector('.total-contactos span');


    let total = 0;

    totalContactos.forEach(contacto => {
        if (contacto.style.display == "table-row" || contacto.style.display === '') {
            if (contacto.id == 'tr-placeholder') {

            } else {
                total++;
            }

        }
    });

    /**
     * dentro de este total se incluye el tr que se usa como placeholder
     * es necesario eliminarle o idear algun tipo de solucion
     * o eliminar uno al contador
     */


    contenedorNumero.textContent = total;

    /**Es importante llamar a esta funcion en situaciones como la adicion de un elemento, la eliminacion de uno
     * llamando al metodo al final de cada uno de estos
     * ademas de al inicio del programa, en la seccion de listener
     */
}