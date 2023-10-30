window.onload = function(){
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");

    closeBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })


    function menuBtnChange(){
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-menu","bx-menu-alt-right")
        }else{
            closeBtn.classList.replace("bx-menu-alt-right","bx-menu")
        }
    }
}
/*AddMedicine na Form*/ 
var addmedform = document.getElementById('myModal');
var btn = document.querySelector('.btn-success');
var closeBtn = document.getElementsByClassName('close')[0];



window.addEventListener('click', function (event) {
  if (event.target == addmedform) {
    addmedform.style.display = 'none';
  }
});
/*Request na Form*/
// JavaScript to open the modal
function openModal() {
    document.getElementById("requestModal").style.display = "block";
  }
  
  // JavaScript to close the modal
  function closeModal() {
    document.getElementById("requestModal").style.display = "none";
  }
  
  // Attach click event to Request buttons
  document.querySelectorAll(".request-button").forEach(function (button) {
    button.addEventListener("click", openModal);
  });
  
  
  
  // Close modal if user clicks outside of it
  window.onclick = function (event) {
    if (event.target == document.getElementById("requestModal")) {
      closeModal();
    }
  };
  