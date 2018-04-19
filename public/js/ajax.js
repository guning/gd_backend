function myAjax(type, url, data, successFun) {
    var xhr = new XMLHttpRequest();
    var readyChange = function(){
        if (xhr.readyState==4 && xhr.status==200) {
            successFun(xhr.responseText);
        }
    }
    xhr.onreadystatechange = readyChange;
    if(type == 1) {
        xhr.open("POST", url, true);
        xhr.send(data);
    } else {
        xhr.open("GET", url, true);
        xhr.send();
    }

}