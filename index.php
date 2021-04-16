<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB lidí</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
</head>
<body>
  <div id="form" style="min-width: 200px; max-width: 20vw">
    <form action="save.php" method="post">
      <input type="text" class="input" name="fname" placeholder="first name" autocomplete="off" required>
      <input type="text" class="input" name="lname" placeholder="last name" autocomplete="off" required>
      <input type="number" class="input" name="age" placeholder="age" autocomplete="off" required>
      <input type="submit" class="is-fullwidth button is-link" value="submit">
    </form>
  </div>

  <div id="table">
  </div>

</body>
</html>

<script>
const table = document.getElementById("table");
main();
async function main(){
  await getTable().then(data => setupTable(data));
}

async function getTable(){
  const response = await fetch('table.php');
  const tableHtml = await response.json();
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
  const row = [...document.querySelector(`tr[data-id="${id}"]`).querySelectorAll('td')].slice(1, -1);
  types = ["text", "text", "number"];
  for (let i = 0; i < row.length; i++) {
    row[i].innerHTML = `<input type='${types[i]}' class='input is-small' style='max-width: 80px' value=${row[i].innerText}>`
  }
}
async function deleteRow(userID){
  const data = new FormData();
  data.append('id', userID);

  await fetch('delete.php', {
    method: 'POST',
    body: data
  })
}
</script>