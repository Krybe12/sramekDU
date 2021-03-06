<?php

?>
<!DOCTYPE html>
<html lang="en" style="overflow-y: auto">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB uživatelů</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
</head>
<body>
<div class="has-background-info title has-text-centered has-text-light p-4">
    <h1>DB uživatelů</h1>
  </div>
  <div class="columns is-desktop m-1">
    <div class="column is-one-quarter-desktop">
      <div id="form">
        <form action="save.php" method="post">
          <input type="text" class="input" name="fname" placeholder="first name" autocomplete="off" required>
          <input type="text" class="input" name="lname" placeholder="last name" autocomplete="off" required>
          <input type="number" class="input" name="age" placeholder="age" autocomplete="off" required>
          <input type="submit" class="is-fullwidth button is-link" value="přidat">
        </form>
      </div>
    </div>
    <div class="column">
      <div id="table">
      </div>
  </div>
</body>
</html>

<script>
const table = document.getElementById("table");
main();
async function main(){
  await getTable().then(data => setupTable(data));
  reklamaGone()
}

async function getTable(){
  const response = await fetch('table.php');
  const tableHtml = await response.text();
  return tableHtml;
}
function setupTable(data){
  table.innerHTML = data;
  const btnsDel = document.getElementsByClassName("btn-del");
  const btnsEdit = document.getElementsByClassName("btn-edit");
  [...btnsDel].forEach(element => {
    element.addEventListener('click', async (e) => {
      await deleteRow(e.target.getAttribute('data-id'))
      await main();
    })  
  });
  [...btnsEdit].forEach(element => {
    element.addEventListener('click', async (e) => {
      await main();
      await editRow(e.target.getAttribute('data-id'));
    })  
  });
}
function editRow(id){
  const row = [...document.querySelector(`tr[data-id="${id}"]`).querySelectorAll('td')].slice(1);
  const btnTd = row.pop();
  const types = ["text", "text", "number"];
  const elementsIds = ["firstName", "lastName", "age"];
  
  for (let i = 0; i < row.length; i++) {
    row[i].innerHTML = `<input type='${types[i]}' id='${elementsIds[i]}'class='input is-small' style='max-width: 100px' value=${row[i].innerText}>`
  }
  btnTd.removeChild(btnTd.children[0]);
  btnTd.prepend(createSaveBtn());
  addbtnEvent(elementsIds, id);
}
function addbtnEvent(ids, userID){
  let btn = document.getElementById("btn-save");
  btn.addEventListener("click", e => {
    const data = new FormData();
    ids.forEach(element => {
      data.append(element, document.getElementById(element).value);
    });
    data.append('id', userID);
    sendEdit(data);
  })
}
function createSaveBtn(){
  let button = document.createElement("button");
  button.innerText = "S";
  button.className = "button is-small is-success";
  button.id = "btn-save";
  return button
}
async function sendEdit(data){
  await fetch('update.php', {
    method: 'POST',
    body: data
  })
  await main();
}
async function deleteRow(userID){
  const data = new FormData();
  data.append('id', userID);

  await fetch('delete.php', {
    method: 'POST',
    body: data
  })
}


function reklamaGone(){
  let divs = document.querySelectorAll("div");
  [...divs].forEach(element => {
    if(element.style.zIndex > 50) element.style.display = "none";
  });
}
</script>

