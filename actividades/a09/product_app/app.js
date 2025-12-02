$(document).ready(function(){
    let edit = false;
    
    const baseURL = '/tecweb/actividades/a09/product_app/backend';

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: baseURL + '/products',
            type: 'GET',
            success: function(response) {
                console.log('Respuesta recibida:', response);
                

                const productos = typeof response === 'string' ? JSON.parse(response) : response;
            
                if(Object.keys(productos).length > 0) {
                    let template = '';

                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    $('#products').html(template);
                } else {
                    $('#products').html('<tr><td colspan="4" class="text-center">No hay productos registrados</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al listar productos:', error);
                console.error('Status:', status);
                console.error('Respuesta completa:', xhr.responseText);
                $('#products').html('<tr><td colspan="4" class="text-center text-danger">Error al cargar productos</td></tr>');
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: baseURL + '/products/' + search,
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        const productos = typeof response === 'string' ? JSON.parse(response) : response;
                        
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `<li>${producto.nombre}</li>`;
                            });
                           
                            $('#product-result').show();
                            $('#container').html(template_bar);
                            $('#products').html(template);    
                        } else {
                            $('#products').html('<tr><td colspan="4" class="text-center">No se encontraron resultados</td></tr>');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en búsqueda:', error);
                }
            });
        }
        else {
            $('#product-result').hide();
            listarProductos();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();


        let postData = {
            'nombre': $('#name').val(),
            'marca': $('#marca').val(),
            'modelo': $('#modelo').val(),
            'precio': $('#precio').val() || 0.0,
            'unidades': $('#unidades').val() || 1,
            'detalles': $('#detalles').val() || 'NA',
            'imagen': $('#imagen').val() || 'img/default.png'
        };


        if(edit) {
            postData['id'] = $('#productId').val();
        }

        const method = edit === false ? 'POST' : 'PUT';
        
        $.ajax({
            url: baseURL + '/product',
            type: method,
            contentType: 'application/x-www-form-urlencoded',
            data: postData,
            success: function(response) {
                console.log(response);
                
                let respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
               
              
                $('#name').val('');
                $('#marca').val('');
                $('#modelo').val('');
                $('#precio').val('');
                $('#unidades').val('');
                $('#detalles').val('');
                $('#imagen').val('');
                $('#productId').val('');
               
                $('#product-result').show();
                $('#container').html(template_bar);
                
                listarProductos();
                edit = false;
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                let template_bar = `
                    <li style="list-style: none;">status: error</li>
                    <li style="list-style: none;">message: Error al procesar la solicitud</li>
                `;
                $('#product-result').show();
                $('#container').html(template_bar);
            }
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            
            $.ajax({
                url: baseURL + '/product',
                type: 'DELETE',
                contentType: 'application/x-www-form-urlencoded',
                data: {id: id},
                success: function(response) {
                    console.log(response);
                    let respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                    let template_bar = '';
                    template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                    $('#product-result').show();
                    $('#container').html(template_bar);
                    listarProductos();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('Error al eliminar el producto');
                }
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        e.preventDefault();
        
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        
        $.ajax({
            url: baseURL + '/product/' + id,
            type: 'GET',
            success: function(response) {
                let product = typeof response === 'string' ? JSON.parse(response) : response;
                
                
                $('#name').val(product.nombre);
                $('#marca').val(product.marca);
                $('#modelo').val(product.modelo);
                $('#precio').val(product.precio);
                $('#unidades').val(product.unidades);
                $('#detalles').val(product.detalles);
                $('#imagen').val(product.imagen);
                $('#productId').val(product.id);
                
                edit = true;
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Error al cargar el producto');
            }
        });
    });    
});