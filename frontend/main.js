function viewItem(name, price, disc, img, id) {
    document.getElementById("prodName").innerHTML = name
    document.getElementById("prodprice").innerHTML = price * (100 - disc) / 100 + " ฿"
    document.getElementById("prodImg").src = img
    document.getElementById("prodId").value = id
}


