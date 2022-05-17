
async function get(url)
{
    return await fetch(url)
        .then(data =>{return data.json()})
        .then(json => console.log(json))
        .catch(err => console.error(error))
}

console.log(get('/api/test'))