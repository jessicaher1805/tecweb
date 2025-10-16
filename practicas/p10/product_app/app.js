// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

function buscarProducto() {
   
    var search = document.getElementById('search').value;
    
    
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        
        if (client.readyState == 4 && client.status == 200) {
            console.log('[RESPONSE]');
            console.log(client.responseText);
            
            
            let productos = JSON.parse(client.responseText);
            
           
            if (productos.length > 0) {
                
                let template = '';
                
                productos.forEach(producto => {
                    
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });
                
                
                document.getElementById("productos").innerHTML = template;
            } else {
                
                document.getElementById("productos").innerHTML = `
                    <tr>
                        <td colspan="3">No se encontraron productos</td>
                    </tr>
                `;
            }
        }
    };
    client.send("search=" + search);
}


function agregarProducto(e) {
    e.preventDefault();

   
    var productoJsonString = document.getElementById('description').value;
    
   
    var nombre = document.getElementById('name').value.trim();
    
    
    if (nombre === '' || nombre.length === 0) {
        alert('ERROR: El nombre del producto es obligatorio');
        return;
    }
    
  
    if (nombre.length > 100) {
        alert('ERROR: El nombre debe tener 100 caracteres o menos');
        return;
    }
    
    try {
       
        var finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        alert('ERROR: El formato del JSON no es válido');
        return;
    }
    
    
    if (!finalJSON.marca || finalJSON.marca.trim() === '') {
        alert('ERROR: La marca es obligatoria');
        return;
    }
    
   
    if (!finalJSON.modelo || finalJSON.modelo.trim() === '') {
        alert('ERROR: El modelo es obligatorio');
        return;
    }
    
   
    if (!finalJSON.precio || parseFloat(finalJSON.precio) <= 99.99) {
        alert('ERROR: El precio debe ser mayor a 99.99');
        return;
    }
    
  
    if (finalJSON.detalles && finalJSON.detalles.length > 250) {
        alert('ERROR: Los detalles deben tener 250 caracteres o menos');
        return;
    }
    
    
    if (!finalJSON.unidades || parseInt(finalJSON.unidades) < 0) {
        alert('ERROR: Las unidades deben ser mayor o igual a 0');
        return;
    }
    
    
    if (finalJSON.imagen && finalJSON.imagen.length > 250) {
        alert('ERROR: La ruta de la imagen debe tener 250 caracteres o menos');
        return;
    }
    
    
    finalJSON['nombre'] = nombre;
    
   
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            
            
            try {
                var respuesta = JSON.parse(client.responseText);
                
              
                if (respuesta.status === 'success') {
                    alert('ÉXITO: ' + respuesta.message);
                    
                    document.getElementById('name').value = '';
                    init(); 
                } else {
                    alert('ERROR: ' + respuesta.message);
                }
            } catch (error) {
                alert('Respuesta del servidor: ' + client.responseText);
            }
        }
    };
    client.send(productoJsonString);
}