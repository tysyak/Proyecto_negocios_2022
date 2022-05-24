if (window.location.pathname !== '/') {
    document.getElementById('listar_recetas').hidden = true;
}

async function listar_receta() {
    let html;
    let response = await fetch('api/receta',{
        "method": "GET",
        "headers": {'Content-Type': 'application/json'}
    }).then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
             html = '<div class="card">';
             response.forEach((receta) => {
                 html += '<img alt="'+ receta.titulo +'" id="image-'+receta.id+'"' +
                     ' src="data:image/png;base64,'+ receta.imagen +
                     '" style="width:100%">';
                 html += '<div class="container">';
                 html += '<h4><b>'+receta.titulo+'</b></h4>';
                 html += '<ul>';
                 receta.materiales.forEach((material => {
                     html += '<li>'+ material.descripcion +'</li>';
                 }))
                 html += '</ul>';
                 html += '</div>';
             });
             html += '</div>';
        });

    document.getElementById('app').innerHTML = html;
}

function exec_fun(fun, params) {
    switch (fun) {
        case 'edit_form_recipe':
            edit_form_recipe(params); break;
        case 'edit_recipe':
            alert(`Se cambio la receta "${params.titulo}"` ); break;
        default:
            console.log(params);
            if (params.status === 200){
                alert(`Acabas de crear la receta nombrada "${params.titulo}"`); break;
            } else {
                alert('Hubo un problema al crear la receta');
            }

    }
}
document.body.addEventListener("submit", async function (event) {
    event.preventDefault();

    let form = event.target;
    let uri = form.action;
    let body = new FormData(form);
    let method = form.method;
    let fun = form.getAttribute('function')
    let init;
    console.log(method)
    switch(form.id) {
        case 'cargar_receta_editar':
            fun = form.getAttribute('function')
            uri += '?id='+body.get('id_receta_to_edit');
            init = {
                "method":  method,
            }
            break;
        default:
            init = {
                "method":  method,
                "headers": { 'accept': 'application/json'},
                "body": body
            }
    }
    let response = await fetch(uri,init)
    let result = await response.json();
    await exec_fun(fun, result);
});

async function edit_form_recipe(params){
    console.log(params);
    document.getElementById('id_receta').value = params.id;
    document.getElementById('titulo').value = params.titulo;
    document.getElementById('image').src = 'data:image/png;base64,' +
        params.image;
    let html = '';
    params.materiales.forEach((elem) => {
        materiales_id = 'materiales[]';
        html += `<input type="text" name="${materiales_id}" id="${materiales_id}"value="${elem.descripcion}">`;
        html += '<br>';
    })
    params.pasos.forEach((elem) => {
        pasos_id = 'pasos[]';
        document.getElementById(pasos_id).value = elem.descripcion;
    })
    document.getElementById('materiales').innerHTML = html;
    document.getElementById('new_receta').disabled=false;
}

function agregar_material(){
    const materiales = document.getElementById("materiales");
    let html = document.createElement('input');
    html.type = 'text';
    html.name = 'pasos[]';
    html.id = 'pasos[]';
    html.required = true;
    materiales.appendChild(document.createElement('br'));
    materiales.appendChild(html);
}

function eliminar_material(){
    const materiales = document.getElementById("materiales");
    materiales.removeChild(materiales.lastChild);
    materiales.removeChild(materiales.lastChild);
}

function preview_image(event)
{
    const reader = new FileReader();
    reader.onload = function()
    {
        const output = document.getElementById('image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}