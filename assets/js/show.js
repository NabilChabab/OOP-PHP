function getData(callback) {
    const xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function () {
      if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        callback(data);
      }
    };
  
    xhr.open('GET', 'http://localhost/happy_marionette/controller/students/show_controller.php', true);
    xhr.send();
  }
  
  window.onload = () => {
    getData((data) => {
      displayDataInTable(data);
    });
  };
  
  
  function displayDataInTable(data) {
    document.querySelector('.data-table').style.marginTop = '0';
    const tableBody = document.querySelector("#data-table tbody");
    tableBody.innerHTML = '';
    const searchInput = document.getElementById("search");
    const searchTerm = searchInput.value.toLowerCase();
  
    data.forEach(item => {
      if (item.nom.toLowerCase().includes(searchTerm) || item.prenom.toLowerCase().includes(searchTerm)) {
        const row = tableBody.insertRow();
        row.style.margin
        row.insertCell(0).textContent = item.id;
        const avatarCell = row.insertCell(1);
        row.insertCell(2).textContent = item.nom;
        row.insertCell(3).textContent = item.prenom;
        row.insertCell(4).textContent = item.email;
        row.insertCell(5).textContent = item.gender;
        const avatarImage = document.createElement('img');
  
        if (item.image && item.image.trim() !== '') {
          avatarImage.src = "../../../assets/images/" +item.image;
          avatarImage.style.maxWidth = '45px';
          avatarImage.style.borderRadius = '50%';
          avatarCell.appendChild(avatarImage);
        } else {
          avatarCell.textContent = 'No Image';
        }
        const actionsCell = row.insertCell(6);

        const editLink = document.createElement('a');
        editLink.href = "edit.php?id=" + item.id;
        editLink.style.color = "black";
        editLink.style.fontSize = "20px";
        editLink.style.marginRight = "20px";
        editLink.innerHTML = '<ion-icon name="pencil-outline"></ion-icon>';
        actionsCell.appendChild(editLink);
  
        const deleteLink = document.createElement('a');
        deleteLink.href = "../../../controller/students/delete_controller.php?id=" + item.id;
        deleteLink.style.color = "red";
        deleteLink.style.fontSize = "20px";
        deleteLink.innerHTML = '<ion-icon name="close-circle-outline"></ion-icon>';
        actionsCell.appendChild(deleteLink);
      }
    });
  }
  
  
  document.getElementById("search").addEventListener("input", () => {
    getData((data) => {
      displayDataInTable(data);
    });
  });