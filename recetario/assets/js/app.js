if (window.location.pathname !== '/') {
    document.getElementById('listar_recetas').hidden = true;
}

async function listar_receta() {
    await fetch('api/receta',{
        "method": "GET",
        "headers": {'Content-Type': 'application/json'}
    }).then((response)=>response.json())
        .then((resp_text)=> {
            let html = '';
            resp_text.forEach((recipe) => {
                html += "<hr><h3>";
                html += recipe.id + ' - ' + recipe.titulo;
                html += "</h3>";
                html += "<ul>";
                recipe.materiales.forEach((material) => {
                    html += `<li>${material.descripcion}</li>`;
                });
                html += "</ul>";
                recipe.pasos.forEach((paso) => {
                    html += "<br>"+paso.descripcion;
                });
            })
            document.getElementById('app').innerHTML = html;

        }).catch((error)=>console.error(error));
}

async function subir_receta(metodo, form) {
    const body = new FormData(form);
    const init = metodo === 'PUT' ? {
        // TODO

    } : {
        // TODO
    };
}

function exec_fun(fun, params) {
    switch (fun) {
        case 'edit_form_recipe': edit_form_recipe(params); break;
    }
}
document.body.addEventListener("submit", async function (event) {
    event.preventDefault();

    let form = event.target;
    let uri = form.action;
    let body = new FormData(form);
    let method = form.method;
    let fun = form.getAttribute('function')
    let init = {};
    switch(form.id) {
        case 'cargar_receta_editar':
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
    let html = '';
    params.materiales.forEach((elem) => {
        paso_id = 'pasos[]';
        html += `<input type="text" name="${paso_id}" id="${paso_id}"value="${elem.descripcion}">`;
        html += '<br>';
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