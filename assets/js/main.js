console.log("check function");
var table = document.getElementsByTagName('table')[0];
table.addEventListener("click",function(event){
        if(event.target.nodeName === 'BUTTON'){
        var params = 'data=' + event.target.id;
        var httpc = new XMLHttpRequest(); // simplified for clarity
        var url = "bootstrap.php";
        httpc.open("POST", url, true); // sending as POST
        if(httpc.readyState === 4 && httpc.status === 200){
            table.reload();
        }
        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        httpc.send(params);
    }
});