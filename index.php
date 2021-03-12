<?php include("db.php"); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/footer.php'); ?>

<?php
$query = $db->prepare("SELECT * FROM tableuser");
$query->execute();

$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container p-4">
    <div class="row">
        <div class="col-md-4">


            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            } ?>


            <div class="card card-body">
                <form action="save_task.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Kitap ismi" autofocus>
                    </div>
                    <div class="form-group">
                        <textarea name="writer" rows="2" class="form-control" placeholder="Yazarı"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="user_id" class="form-select form-control" aria-label="Ekleyen">
                            <?php
                            foreach ($users as $user) {
                                ?>
                                <option value="<?php echo $user['id'] ?>"><?php echo $user['user_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="save_task" class="btn btn-success btn-block" value="Kitap Ekle">
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Kitap</th>
                    <th>Yazar</th>
                    <th>Ekleyen</th>
                    <th>Islemler</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $query = $db->query("SELECT * FROM `tablebook` LEFT JOIN tableuser ON tablebook.user_id = tableuser.id", PDO::FETCH_ASSOC);
                $result = $query->fetchAll();
                foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['writer_name']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                                <i class="fas fa-marker"></i>
                            </a>
                            <a href="delete_task.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>