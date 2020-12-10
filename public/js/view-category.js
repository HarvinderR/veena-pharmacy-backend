function addCatItem(id, name, title) {
    var txt = "<tr>" +
        "<td>"+id+"</td>" +
        "<td>"+name+"</td>" +
        "<td>"+title+"</td>" +
        "<td> " +
        "<button class='btn btn-secondary' onclick='showProduct("+id+")'>Products</button> " +
        "<button class='btn btn-secondary' onclick='deleteCategory("+id+")'>Delete</button> " +
        "</td>" +
        "</tr>";
    $("#tbodyid").append(txt)
}
function deleteCategory(id) {
    if (confirm("Are you sure you want to delete #"+id+" ?")) {
        axios.post('deleteCat',{"id":id}).then((resp)=>{
            for(i =0; i < category.length; i++ ){
                if( category[i]['id'] == id ){
                    ite =i
                    break
                }
            }
            console.log("ite "+ite)
            category.splice(ite,1)
            fillDataByCategory()
        },(error)=>{

        })
    } else {
        txt = "You pressed Cancel!";
    }
}

function showProduct(id){
    console.log(id)
    for(i =0 ; i< category.length;i++){
        if( category[i]['id'] == id ){
            $("#tbodyProduct").empty();
            axios.post('getProductsByCat',{'id':id}).then(
                (resp)=>{
                    console.log(resp)
                    var d = resp['data'];
                    d.forEach(it =>{
                        var txt = "<tr>" +
                            "<td>"+it["id"]+"</td>" +
                            "<td>"+it["name"]+"</td>" +
                            "<td>"+it["salt"]+"</td>" +
                            "</tr>";
                        $("#tbodyProduct").append(txt)
                    })
                },(error)=>{
                    console.log(error)
                }
            )
            $("#catNameModal").text( category[i]['name'])
            $('#showProductModal').modal('show')
            break;
        }
    }
}

var category;

$( document ).ready(function() {
    console.log( "ready!" );
    refreshOrInit()
});

function refreshOrInit() {
    axios.get("getAllCategories").then( (resp)=>{
        console.log(resp['data'])
        category = resp['data']
        fillDataByCategory()
    },(error)=>{
        console.log(error)
    } )
}

function fillDataByCategory() {
    $("#tbodyid").empty()
    category.forEach(it =>{
        addCatItem(it['id']+"",it['name'],it['title'] )
    })
}
