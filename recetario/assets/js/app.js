async function listar_receta() {
    await fetch('api/receta',{
        "method": "GET",
        "headers": {'Content-Type': 'application/json'}
    }).then((response)=>response.json())
        .then((resp_text)=> {
            let html = '';
            resp_text.forEach((recipe) => {
                html += "<h3>";
                html += recipe.id + ' - ' + recipe.titulo;
                html += "</h3>";
                html += "<ul>";
                recipe.materiales.forEach((material) => {
                    html += "<li>"+material.descripcion+"</li>";
                });
                html += "</ul>";
                recipe.pasos.forEach((paso) => {
                    html += "<br>"+paso.descripcion;
                });
            })
            document.getElementById('app').innerHTML = html;

        }).catch((error)=>console.error(error));
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
    console.log(params.titulo);
    document.getElementById('ed_id_receta').value = params.id;
    document.getElementById('ed_titulo').value = params.titulo;
    let html = '';
    params.materiales.forEach((elem) => {
        paso_id = 'id_receta='+params.id+'&id_paso='+elem.id_material
        html += '<input type="text" name="'+paso_id+'" id="'+paso_id+'"' +
            'value="'+elem.descripcion+'">';
    })
    document.getElementById('ed_materiales').innerHTML = html;
    document.getElementById('ed_receta').disabled=false;


}

