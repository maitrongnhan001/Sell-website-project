 <!-- Food Search Section Starts Here -->
 <?php
 function ShowResult($result)
 {
     $_SESSION['search'] = 'Kết quả cho "' . $result.'"';
 }
 ?>
 <section class="product-search text-center">
     <div class="container">

         <form action="" method="POST">
             <input type="search" name="search" placeholder="Tìm kiếm sản phẩm ..." required>
             <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-primary">
             <br>
             <br>
             <h2 class="white text-center">
                 <?php
                    if (isset($_SESSION['search'])) {
                        echo $_SESSION['search'];
                        unset($_SESSION['search']);
                    }
                    ?>
             </h2>
         </form>
     </div>
 </section>

 <?php
 include('./Config/connect.php');
    if (isset($_POST['submit'])) {
        //get value search
        if (isset($_POST['submit'])) {
            $valueSearch = $_POST['search'];
            ShowResult($valueSearch);
            header('location: '.URL.'Customer/search-page.php?search='.$valueSearch);
        }
        //unset search
        unset($_POST['submit'], $_POST['search']);
    }
?>