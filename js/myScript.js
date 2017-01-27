function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('newPassword');
    var pass2 = document.getElementById('confirmPassword');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass1.style.backgroundColor = goodColor;
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!";
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass1.style.backgroundColor = badColor;
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!";
    }
} 


// Get the modal
var modal = document.getElementById('deleteUserModal');
var resetPWmodal = document.getElementById('resetPasswordModal');

// Get the button that opens the modal
var deleteUserBtn = document.getElementById("deleteUserBtn");
var resetPWBtn = document.getElementById("resetPWBtn");

// Get the <span> element that closes the modal
var span1 = document.getElementsByClassName("close1")[0];
var span2 = document.getElementsByClassName("close2")[0];

var no1 = document.getElementById("noBtn1");
var no2 = document.getElementById("noBtn2");

no1.onclick = function() {
    modal.style.display = "none";
}
no2.onclick = function() {
    resetPWmodal.style.display = "none";
}

// When the user clicks on the button, open the modal 
deleteUserBtn.onclick = function() {
    modal.style.display = "block";
}
resetPWBtn.onclick = function() {
    resetPWmodal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span1.onclick = function() {
    modal.style.display = "none";
    resetPWmodal.style.display = "none";
}

span2.onclick = function() {
    modal.style.display = "none";
    resetPWmodal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }