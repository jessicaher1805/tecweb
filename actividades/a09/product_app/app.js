var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/products',
            type: 'GET',
            success: function(response) {
                console.log(response);
                
                const productos = JSON.parse(response);
            
               
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
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al listar productos:', error);
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/products/' + search,
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                       
                        const productos = JSON.parse(response);
                        
                        
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

                                template_bar += `
                                    <li>${producto.nombre}</li>
                                `;
                            });
                           
                            $('#product-result').show();
                           
                            $('#container').html(template_bar);
                            
                            $('#products').html(template);    
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

       
        let postData = JSON.parse($('#description').val());
       
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();


        const url = './backend/product';
        const method = edit === false ? 'POST' : 'PUT';
        
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/x-www-form-urlencoded',
            data: postData,
            success: function(response) {
                console.log(response);
                
                let respuesta = JSON.parse(response);
               
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
               
                $('#name').val('');
                $('#description').val(JsonString);
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
                url: './backend/product',
                type: 'DELETE',
                contentType: 'application/x-www-form-urlencoded',
                data: {id: id},
                success: function(response) {
                    console.log(response);
                    let respuesta = JSON.parse(response);
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
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        
        $.ajax({
            url: './backend/product/' + id,
            type: 'GET',
            success: function(response) {
                
                let product = JSON.parse(response);
                
                $('#name').val(product.nombre);
                
                $('#productId').val(product.id);
                
                delete(product.nombre);
                delete(product.eliminado);
                delete(product.id);
                
                let JsonString = JSON.stringify(product, null, 2);
              
                $('#description').val(JsonString);
                
                edit = true;
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Error al cargar el producto');
            }
        });
        e.preventDefault();
    });    
});