

var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var v1 = false;
var v2 = false;
var v3 = false;
var v4 = false;


$(document).ready(function() {

  document.getElementById("psw").onblur =function (){
 // Validate lowercase letters
 var lowerCaseLetters = /[a-z]/g;
 if(myInput.value.match(lowerCaseLetters)) {  
   letter.classList.remove("invalid");
   letter.classList.add("valid");
   v1 = true;
 } else {
   letter.classList.remove("valid");
   letter.classList.add("invalid");
   v1 = false;
 }
 
 // Validate capital letters
 var upperCaseLetters = /[A-Z]/g;
 if(myInput.value.match(upperCaseLetters)) {  
   capital.classList.remove("invalid");
   capital.classList.add("valid");
   v2 = true;
 } else {
   capital.classList.remove("valid");
   capital.classList.add("invalid");
   v2 = false;
 }

 // Validate numbers
 var numbers = /[0-9]/g;
 if(myInput.value.match(numbers)) {  
   number.classList.remove("invalid");
   number.classList.add("valid");
   v3 = true;
 } else {
   number.classList.remove("valid");
   number.classList.add("invalid");
   v3 = false;
 }
 
 // Validate length
 if(myInput.value.length >= 8) {
   length.classList.remove("invalid");
   length.classList.add("valid");
   v4 = true;
 } else {
   length.classList.remove("valid");
   length.classList.add("invalid");
   v4 = false;
 }


  }
});


// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  //document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  //document.getElementById("message").style.display = "none";
}

 
// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
   
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
   
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}



