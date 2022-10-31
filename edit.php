<?php

require_once('connection.php');

$id = $_GET['id'];

if ( isset($_POST['edit']) && $_POST['edit']== "Salvesta" ) {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, stock_saldo = :stock_saldo, price = :price WHERE id = :id');
    $stmt->execute(['title' => $_POST['title'], 'stock_saldo' => $_POST['stock-saldo'], 'price' => str_replace(',', '.', $_POST['price']), 'id' => $id]); #nt str replace asendab koma punktiga

    header('Location: book.php?id=' . $id);
};

# SELECT * FROM 'authors'
#     <main>
# <ul> 
# <?php while ($book = $stmt->fetch()) { ?>
<!--  <li>
#          <a href="book.php?id=<?#=$book['id'];?>"><?#=$book['title'];?></a>
#     </li>
# <?#php } ?>
# </ul>
# </main>
# -->

<?
$stmtBook = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmtBook->execute(['id' => $id]);
$book = $stmtBook->fetch();

// var_dump($book);

$stmtBookAuthors = $pdo->prepare('SELECT * FROM authors LEFT JOIN book_authors ON authors.id=book_authors.author_id WHERE book_authors.book_id = :id');
$stmtBookAuthors->execute(['id' => $id]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$book['title'];?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>
<body>
    
<form action="edit.php?id=<?=$id;?>" method="POST">
    <label for="title">Pealkiri:</label> <input type="text" name="title" value="<?=$book['title'];?>" style="width 320px">
    <br>
    <label for="stock-saldo">Laos:</label> <input type="text" name="stock-saldo" value="<?=$book['stock_saldo'];?>">
    <br>
    
    <label for="price">Hind (€):</label> <input type="text" name="price" value="<?=number_format(round($book['price'], 2), 2, ',');?>"> 
    <br>
    <label for="authors">Autorid:</label> <input type="text" name="authors" value="<?=$book_authors['first_name'], ['last_name'];?>">
    <br>


    <div style="font-weight: bold;">Autorid</div>
    <select name="authors">
        <option value=""></option>
        <?php while ($author = $stmtAuthors->fetch()) { ?>
            <option value="<?=$author['id'];?>"><?=$author['first_name'];?> <?=$author['last_name']?>;></option>
        <?php } ?>
    </select>
    <br>
    <?php while ($bookAuthor = $stmtBookAuthors->fetch()) { ?>
        <div class="author-row">
            <?=$author['first_name'];?> <?=$author['last_name']?>
            <span class="material-symbols-outlined" style=""></span>
        </div>
    <?php } ?>
    <input type="submit" value="Salvesta" name="edit">
</form>

</body>
</html>

