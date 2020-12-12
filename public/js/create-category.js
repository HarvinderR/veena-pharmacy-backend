var isSearching=false;
var inputText= "";
var product_item = [];
var isSaving = false;
$( document ).ready(function() {
    console.log( "ready!" );
    var inputElement = $('#myInput')
    inputElement.keyup(function (e) {
        var _text = inputElement.val();
        if(_text != inputText){
            inputText = _text;
            searchProduct(inputText)
        }
    })
});

function searchProduct(txt) {
    if (typeof txt === 'string' || txt instanceof String){
        if(isSearching || txt == '' || txt == null || txt == undefined){
            closeAllLists()
            return
        }
        //console.log(txt)
        isSearching = true
        axios.post('searchProducts',{'data':txt}).then(
            (response) => {
                isSearching=false
                console.log("success")
                closeAllLists()
                var a = document.createElement("DIV");
                a.setAttribute("id",  "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");

                response['data'].forEach( it => {
                    //console.log(it['name'])
                    b = addDropdownItems( it['id']+"",it['name']+"",it['salt'])
                    if(b != null || b != undefined){
                        a.appendChild(b);
                        $(".autocomplete").append(a)
                    }
                }  )
                if ((typeof txt === 'string' || txt instanceof String)&&(typeof inputText === 'string' || inputText instanceof String)){
                    if(txt != inputText){
                        searchProduct(inputText)
                    }
                }
            }, (error) => {
                isSearching=false
                closeAllLists()
                console.log("error");
                console.log(error);
                if ((typeof txt === 'string' || txt instanceof String)&&(typeof inputText === 'string' || inputText instanceof String)){
                    if(txt != inputText){
                        searchProduct(inputText)
                    }
                }
            }
        )
    }
}
function addDropdownItems(id,name,salt) {
    // console.log("check1")
    // console.log(typeof id)
    // console.log(typeof name)
    if ((typeof id === 'string' || id instanceof String)&&(typeof name === 'string' || name instanceof String)){
        var parentDiv = document.createElement("DIV");
        parentDiv.setAttribute("class", "autocomplete-item")
        // console.log("check2")
        /*var a = document.createElement("DIV");
        a.setAttribute("id", id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");*/
        /*create a DIV element for each matching element:*/
        var b = document.createElement("DIV");
        /*make the matching letters bold:*/
        //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
        b.innerHTML += name;
        /*insert a input field that will hold the current array item's value:*/
        b.innerHTML += "<input type='hidden' value='" + id + "'>";

        var pSalt = document.createElement("p");
        pSalt.setAttribute("class", "autocomplete-item-salt")
        pSalt.innerText+=salt
        parentDiv.append(b)
        parentDiv.append(pSalt)
        /*execute a function when someone clicks on the item value (DIV element):*/
        parentDiv.addEventListener("click", function(e) {
            /*insert the value for the autocomplete text field:*/
            addProductItem(id,name)
            // $('#myInput').val(name);
            console.log($('#myInput').val()  )
            /*close the list of autocompleted values,
            (or any other open lists of autocompleted values:*/
            //closeAllLists();
        });
        return parentDiv;
    }
    return null;
}

function removeItemOnce(arr, value) {
    var index = arr.indexOf(value);
    if (index > -1) {
        arr.splice(index, 1);
    }
    return arr;
}

function addProductItem(id,name) {
    var isFind=false;
    product_item.forEach( element => {
        if( element['id'] == id ){
            isFind=true;
        }
    })
    if(isFind){
        return
    }

    var tr = document.createElement("TR");
    tr.setAttribute("id", "product-items-"+id);
    tr.setAttribute("class", "product-items");
    var td_id = document.createElement("TD");
    td_id.innerText+= id;
    var td_name = document.createElement("TD");
    td_name.innerText+=name
    var td_option = document.createElement("TD");
    var btn_delete = document.createElement('button')
    btn_delete.innerText+= "Delete"
    btn_delete.setAttribute('class','btn btn-secondary')
    btn_delete.addEventListener("click", function (e) {
        console.log(id)
        console.log(name)
        var ite = null
        for(i =0; i < product_item.length; i++ ){
            if( product_item[i]['id'] == id ){
                ite =i
                break
            }
        }
        console.log("ite "+ite)
        product_item.splice(ite,1)

        $("#product-items-"+id).remove()
    } )
    td_option.append(btn_delete)
    tr.append(td_id)
    tr.append(td_name)
    tr.append(td_option)
    product_item.push({'id':id,'name':name})
    $("#tbodyid").append(tr);
}

function closeAllLists(){
    $(".autocomplete-items").remove()
}

function saveCategory() {
    /*testApi()
    return*/
    if(isSaving){
        return
    }
    if(product_item.length<1){
        alert("Please add products")
        return
    }
    isSaving=true
    req = {
        "name":$("#CategoryNameControlInput1").val(),
        "title":$("#CategoryTitleControlInput1").val(),
        "category":$("#exampleFormControlSelect1").val(),
        "products":product_item
    }
    req = {
        "data":req
    }
    axios.post("saveCategory",req).then( (resp) => {
        console.log(resp)
        resetView()
        isSaving =false
        alert("Category saved successfully")
    },(error) => {
        console.log(error)
        isSaving=false;
        alert("Failed to create category")
    } )
    console.log(req)
}

function resetView() {
    product_item = [];
    closeAllLists();
    $("#CategoryNameControlInput1").val("")
    $("#CategoryTitleControlInput1").val("")
    $('#myInput').val("")
    $('#tbodyid').empty()
}

function testApi() {
    axios.post('getProductsByCat',{id:3}).then( (resp) =>{
        console.log(resp)
    },(error)=>{
        console.log(error)
    }  )
}
