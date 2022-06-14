function attachValidationEvents(){
    const name = document.getElementById("name");;
    const phone = document.getElementById("phone");
    const address = document.getElementById("address");
    const city = document.getElementById("city");

    nameEvent(name);
    phoneEvent(phone);
    addressEvent(address);
    cityEvent(city);
}   

function nameEvent(name){
    name.addEventListener("input", function () {
        input = name.value;
        warning = name.nextElementSibling;
        if(/[<>"')(;\/#&]/.test(input.trim())){
            warning.textContent = "invalid characters detected";
        }
        else if(input.trim().length > 50){
            warning.textContent = "name can't have more than 50 characters";
        }
        else {
            warning.textContent = "";
        }
    })
}

function phoneEvent(phone) {
    phone.addEventListener("input", async function() {
        input = phone.value;
        warning = phone.nextElementSibling;
        if(!/^(?:9[1-36]\d|2[12]\d|2[35][1-689]|24[1-59]|26[1-35689]|27[1-9]|28[1-69]|29[1256])\d{6}$/.test(input.trim())){
            warning.textContent = "invalid phone number";
        }
        else {
            const data = new FormData();
            data.append("phone" ,input.trim());

            const response = await fetch("../api/form_validation/api_phone_restaurant.php", {
                method: "POST",
                body: data,
            });    
            
            if(await response.json()){
                warning.textContent = "phone number is taken";
            }
            else {
                warning.textContent = "";
            }
        }
    });
}

function addressEvent(address){
    address.addEventListener("input", function () {
        input = address.value;
        warning = address.nextElementSibling;
        if(/[<>"')(;\/#&]/.test(input.trim())){
            warning.textContent = "invalid characters detected";
        }
        else {
            warning.textContent = "";
        }
    });
}

function cityEvent(city){
    city.addEventListener("input", function () {
        input = city.value;
        warning = city.nextElementSibling;
        if(/[<>"')(;\/#&]/.test(input.trim())){
            warning.textContent = "invalid characters detected";
        }
        else {
            warning.textContent = "";
        }
    });
}

attachValidationEvents();

function validateForm(){
    const form = document.forms["newRestaurant"];

    const name = form["name"].value.trim();
    const phone = form["phone"].value.trim();
    const address =form["address"].value.trim();
    const city = form["city"].value.trim();

    const form_data = new FormData(document.querySelector("form"));
    if(!form_data.has("categories[]")){
        alert("please choose at least one category");
        return false;
    }

    if(name === ""){
        alert("please enter a name");
        return false;
    }
    if(phone === ""){
        alert("Please enter a phone number");
        return false;
    }
    if(address === ""){
        alert("Please enter an address");
        return false;
    }
    if(city === ""){
        alert("Please enter a city");
        return false;
    }
    if(/[<>"')(;\/#&]/.test(name)){
        alert("invalid characters detected in name");
        return false;
    }
    if(!/^(?:9[1-36]\d|2[12]\d|2[35][1-689]|24[1-59]|26[1-35689]|27[1-9]|28[1-69]|29[1256])\d{6}$/.test(phone)){
        alert("please enter a valid phone number");
        return false;
    }
    if(/[<>"')(;\/#&]/.test(address)){
        alert("invalid characters detected in address");
        return false;
    }
    if(/[<>"')(;\/#&]/.test(city)){
        alert("invalid characters detected in city");
        return false;
    }
    return true;
}