// nav bar
const hamburger = document.querySelector(".ham");
const navsub = document.querySelector(".nav-sub");
hamburger.addEventListener('click', () => {
    hamburger.classList.toggle("change")
    navsub.classList.toggle("nav-change")
});
// fin nav bar

// Modal
// Get the modal
let modal = document.getElementById("gen-modal");

// Get the <span> element that closes the modal

// When the user clicks on <span> (x), close the modal
function mostrar_modal(cuerpo, titulo, pie, tipo='warn') {
    let header = document.getElementById('modal-header');
    let body = document.getElementById('modal-body');
    let footer = document.getElementById('modal-footer');

    let clase;
    switch (tipo) {
        case 'error' :
            clase = 'modal-error';
            break;
        case 'success':
            clase = 'modal-success';
            break;
        default:
            clase = 'modal-warn';
            break
    }

    header.className = 'modal-header ' + clase;
    footer.className = 'modal-footer ' + clase;

    header.innerHTML = '<span class="close-modal" onclick="ocultar_modal()">&times;</span>' + `<h2>${titulo}</h2>`;
    footer.innerHTML = `<h3>${pie}</h3>`
    body.innerHTML = cuerpo;

    header.innerHTML = '<span class="close-modal" onclick="ocultar_modal()">&times;</span>' + `<h2>${titulo}</h2>`

    modal.style.display = "block";
}

function ocultar_modal() {
    modal.style.display = "none";
    return false
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        ocultar_modal();
    }
}

// Fin de Modal
async function listar_receta() {
    let html = '<div class="cards">';
    let uri = '/api/receta';
    if (typeof username !== 'undefined') {
        uri += '?username='+username
    }
    await fetch(uri,{
        "method": "GET",
        "headers": {'Content-Type': 'application/json'}
    }).then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(async response => {
            response.forEach((receta) => {
                let img_src = receta.imagen == null ? 'src="/recetario/assets/img/food_default.png"'
                    : `src="data:image/png;base64,${receta.imagen}`;
                html += '<div class="card">';
                html += `<img class='img-recipe' alt="${receta.titulo}" id="image-${receta.id}" ${img_src}" style="width:100%">`;
                html += '<div class="container">';
                html += '<h4><b>'+receta.titulo+'</b></h4>';
                html += '<ul>';
                receta.materiales.forEach((material => {
                    html += '<li>'+ material.descripcion +'</li>';
                }))

                html += '</ul>';

                html += `<input type="checkbox" class="read-more-state" id="${receta.id}" />`;

                receta.pasos.forEach((paso => {
                    html += '<p class="read-more-wrap" style="text-align: justify;"><br><span class="read-more-target">' +
                        paso.descripcion +'</span></p> ';
                }))

                html += `<label for="${receta.id}" class="btn read-more-trigger"></label><br>`;
                if (typeof username !== 'undefined') {
                    html += (receta.favorito) ? `<button id='btn-fav-${receta.id}' class="badge btn-danger" onclick="toggle_fav(${receta.id})">Eliminar de favoritos</button>` :
                        `<button id='btn-fav-${receta.id}' class="badge btn-success" onclick="toggle_fav(${receta.id})">Añadir a favoritos</button>`;
                }
                html += '</div>';
                html += '</div>';
            });
            html += '</div>';
            html += '</div>';
        });
    document.getElementById('app').innerHTML = html;
}



async function toggle_fav(id) {
    let fav_btn = document.getElementById('btn-fav-'+id);
    const body =  `?username=${username}&id_receta=${id}`
    console.log(body)
    const to_del = 'badge btn-danger';
    const to_fav = 'badge btn-success'
    await fetch('/api/esfavorito'+body,{
        method: 'get',
        headers: {
            'accept': 'application/json'
        }
    }).then(async result => {
        const status = result.status;
        const data = await result.json();
        switch (data.action) {
            case 'del':
                fav_btn.className = to_fav;
                fav_btn.innerText = 'Añadir a favoritos';
                mostrar_modal(
                    'Se elimino la receta de forma exitosa',
                    'Eliminado de favoritos',
                    '',
                    'success'
                );
                break;
            case 'add':
                fav_btn.className = to_del
                fav_btn.innerText = 'Eliminar de favoritos';
                mostrar_modal(
                    'Se añadio la receta de forma exitosa',
                    'Añadido a favoritos',
                    '',
                    'success'
                );
                break;

            default:
                mostrar_modal(
                    'Verifica que iniciaste sessión',
                    'Ocurrio un error',
                    '',
                    'error'
                );
                break;
        }
    });}



function exec_fun(fun, params, status) {
    switch (fun) {
        case 'edit_form_recipe':
            edit_form_recipe(params); break;
        case 'edit_recipe':
            ocultar_modal();
            mostrar_modal(params.msg,
                'Exito',
                '',
                'success'); break;
        default:
            switch (status){
                case 200:
                    ocultar_modal();
                    mostrar_modal(
                        params.msg,
                        'Exito',
                        '',
                        'success');
                    break;
                case 404:
                    ocultar_modal();
                    mostrar_modal('Hubo un problema, la solicitud no existe',
                        'Error',
                        '',
                        'error');
                    break;
                default:
                    ocultar_modal();
                    mostrar_modal('Hubo un problema, verifique los datos',
                        'Error',
                        '');

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

    switch(form.id) {
        case 'cargar_receta_editar':
            fun = form.getAttribute('function')
            uri += '?id='+body.get('id_receta_to_edit');
            init = {
                "headers": { 'accept': 'application/json'},
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
    mostrar_modal('Espera un momento...','Cargando','');
    fetch(uri,init)
        .then(async result => {
            const status = result.status;
            const data = await result.json();
            exec_fun(fun, data, status);
        })
        .catch(error => {
            exec_fun('fail', {status: 404}, 404)
        });
});

async function edit_form_recipe(params){
    document.getElementById('id_receta').value = params.id;
    document.getElementById('titulo').value = params.titulo;
    document.getElementById('image').className = 'class=\'img-recipe\'';
    document.getElementById('image').src = params.image == null ? '/recetario/assets/img/food_default.png'
        : `data:image/png;base64,${params.image}`;
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
    ocultar_modal();
}

function agregar_material(){
    const materiales = document.getElementById("materiales");
    let html = document.createElement('input');
    html.type = 'text';
    html.name = 'materiales[]';
    html.id = 'materiales[]';
    html.autocomplete = 'off';
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
