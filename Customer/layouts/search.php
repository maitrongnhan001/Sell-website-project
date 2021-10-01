 <!-- Food Search Section Starts Here -->
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
    function ShowResult($result)
    {
        $_SESSION['search'] = 'Kết quả cho "' . $result.'"';
    }
    ?>