<?php

require_once "../model/user.php";
require_once "../controller/user_controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="\OOP-PHP\assets\css\style.css">

</head>
<style>
    .admin {
        display: flex;
        gap: 1rem;
    }

    .name p {
        font-weight: bold;
        color: grey;
    }

    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.user-details {
    text-align: center;
}

.user-details p {
    font-size: 18px;
    margin-bottom: 10px;
}
</style>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation active" style="">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Happy-marionnette</span>
                    </a>
                </li>

                <li class="active">
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main active">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here" id="searchTerm">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="admin">
                    <div class="user">
                        <?php
                        if (isset($_SESSION['user_image'])) {
                            echo '<img src="' . $_SESSION['user_image'] . '" alt="User Image">';
                        }
                        ?>
                    </div>
                    <div class="name">
                        <p>
                            <?php echo isset($_COOKIE['user_name']) ? $_COOKIE['user_name'] : ''; ?>
                        </p>
                        <p>
                            <?php echo isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : ''; ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="cardBox">
                <?php
                $all = $user->showUserLimit();
                if ($all) {
                    while ($rows = mysqli_fetch_assoc($all)) {
                        ?>
                        <div class="card">
                            <div>
                                <div class="numbers" style="font-size:25px;">
                                    <?= $rows['first_name'] ?>
                                </div>
                                <div class="cardName">
                                    <?= $rows['email'] ?>
                                </div>
                            </div>

                            <div class="iconBx">
                                <img src="<?= $rows['profile'] ?>" alt="" srcset="" style="max-width:50px;border-radius:50%;">
                            </div>

                        </div>

                        <?php
                    }
                }
                ?>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>All Users</h2>
                        <?php
                        if (!isset($_SESSION['user_role'])) {
                            echo '<a href="add.php" class="btn">Add New</a>';
                        }
                        ?>
                    </div>
                    <div id="userModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <div id="modalDetails" class="user-details"></div>
                        </div>
                    </div>
                    <table id="userTable">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Profile</td>
                                <td>FirstName</td>
                                <td>LastName</td>
                                <td>Email</td>
                                <td>Gender</td>
                                <td>Date</td>
                                <?php
                                if (!isset($_SESSION['user_role'])) {
                                    echo '<td>Action</td>';
                                }
                                ?>
                            </tr>
                        </thead>

                        <tbody id="userTableBody">
                            <?php
                            $all = $user->showUser();
                            if ($all) {
                                while ($row = mysqli_fetch_assoc($all)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $row['id'] ?>
                                        </td>
                                        <td><img src="<?= $row['profile'] ?>" alt="" srcset=""
                                                style="max-width:45px;border-radius:50%;"></td>
                                        <td>
                                            <?= $row['first_name'] ?>
                                        </td>
                                        <td>
                                            <?= $row['last_name'] ?>
                                        </td>
                                        <td>
                                            <?= $row['email'] ?>
                                        </td>
                                        <td>
                                            <?= $row['gender'] ?>
                                        </td>
                                        <td>
                                            <?= $row['creation_date'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!isset($_SESSION['user_role'])) {
                                                echo '<a href="edit.php?id=' . base64_encode($row['id']) . '" style="color:black;font-size:20px;margin-right:20px"><ion-icon name="pencil-outline"></ion-icon></a>';
                                                echo '<a href="?id=' . base64_encode($row['id']) . '&delete" style="color:red;font-size:20px;"><ion-icon name="close-circle-outline"></ion-icon></a>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->

            </div>

            <!-- ======================= Cards ================== -->
        </div>

    </div>

    <!-- =========== Scripts =========  -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/filter.js"></script>

    <script>
        const rows = document.querySelectorAll('#userTableBody tr');

function openModal(userDetails) {
    document.getElementById('modalDetails').innerHTML = userDetails;
    document.getElementById('userModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('userModal').style.display = 'none';
}

rows.forEach(row => {
    row.addEventListener('click', function () {
        const userId = this.querySelector('td:first-child').innerText;
        const firstName = this.querySelector('td:nth-child(3)').innerText;
        const lastName = this.querySelector('td:nth-child(4)').innerText;
        const email = this.querySelector('td:nth-child(5)').innerText;
        const gender = this.querySelector('td:nth-child(6)').innerText;

        const userDetails = `
            <p>User ID: ${userId}</p>
            <p>First Name: ${firstName}</p>
            <p>Last Name: ${lastName}</p>
            <p>Email: ${email}</p>
            <p>Gender: ${gender}</p>
            <!-- Add more details as needed -->
        `;

        openModal(userDetails);
    });
});

    </script>



    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>