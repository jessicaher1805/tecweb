// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    
    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

// SE EJECUTA AL CARGAR EL DOCUMENTO
$(document).ready(function() {
    init();
    
    // LISTENER PARA EL FORMULARIO DE AGREGAR PRODUCTO
    $('#product-form').submit(function(e) {
        e.preventDefault();
        agregarProducto();
    });
    
    // LISTENER PARA EL FORMULARIO DE BÚSQUEDA
    $('#search-form').submit(function(e) {
        e.preventDefault();
        var search = $('#search').val();
        buscarProducto(search);
    });
    
    // LISTENER PARA BÚSQUEDA EN TIEMPO REAL (keyup)
    $('#search').keyup(function() {
        var search = $(this).val();
        if(search) {
            buscarProducto(search);
        } else {
            listarProductos();
            $('#product-result').addClass('d-none');
        }
    });
    
    // LISTENER PARA BOTONES DE ELIMINAR (delegación de eventos)
    $(document).on('click', '.product-delete', function() {
        if(confirm('¿De verdad deseas eliminar el Producto?')) {
            var productId = $(this).closest('tr').attr('productId');
            eliminarProducto(productId);
        }
    });
});

// FUNCIÓN PARA LISTAR TODOS LOS PRODUCTOS
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';
                
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#products').html(template);
            }
        },
        error: function(error) {
            console.error('Error al listar productos:', error);
        }
    });
}

// FUNCIÓN PARA BUSCAR PRODUCTOS
function buscarProducto(search) {
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';
                let template_bar = '';
                
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    template_bar += `<li>${producto.nombre}</li>`;
                });
                
                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').removeClass('d-none').addClass('d-block');
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                // SE INSERTA LA PLANTILLA EN LA TABLA
                $('#products').html(template);
            } else {
                $('#product-result').addClass('d-none');
                $('#products').html('');
            }
        },
        error: function(error) {
            console.error('Error al buscar productos:', error);
        }
    });
}

// FUNCIÓN PARA AGREGAR PRODUCTO
function agregarProducto() {
    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = $('#description').val();
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = $('#name').val();
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON, null, 2);
    
    /**
     * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
     * ...
     * 
     * --> EN CASO DE NO HABER ERRORES, SE ENVÍA EL PRODUCTO A AGREGAR
     */
    
    $.ajax({
        url: './backend/product-add.php',
        type: 'POST',
        contentType: 'application/json;charset=UTF-8',
        data: productoJsonString,
        success: function(response) {
            console.log(response);
            let respuesta = JSON.parse(response);
            
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
            
            // SE LIMPIA EL FORMULARIO
            $('#product-form')[0].reset();
            $('#description').val(JSON.stringify(baseJSON, null, 2));
        },
        error: function(error) {
            console.error('Error al agregar producto:', error);
        }
    });
}

// FUNCIÓN PARA ELIMINAR PRODUCTO
function eliminarProducto(id) {
    $.ajax({
        url: './backend/product-delete.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            console.log(response);
            let respuesta = JSON.parse(response);
            
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
        },
        error: function(error) {
            console.error('Error al eliminar producto:', error);
        }
    });
}