<?php if ($_SESSION['login_access'] == '0') { 
    include('error.php');
}?>

<?php 
include('include/db_connect.php');
$userInfo = $conn->query("SELECT * FROM tbl_user_information WHERE user_account_id = " . $_SESSION['login_id'] . " LIMIT 1")->fetch_array();
$name = ucwords($userInfo['fName']) . " ";
if (!empty($userInfo['mName']) && is_string($userInfo['mName'])) {
  $name .= ucwords($userInfo['mName'][0]) . ". ";
}
$name .= ucwords($userInfo['lName']);
?>
<?php 
$query = $conn->query("SELECT * FROM tbl_movie_info");
if ($query->num_rows == 0) {?>
  <script type="text/javascript"> window.location.href = 'index.php?page=movies';</script>
  <?php   exit();
}
?>
<style type="text/css">
  .movie-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  .movie-item {
    border: 1px solid;
    padding: 10px;
    text-align: center;
    cursor: pointer;
  }
  .grid_pic{
    height: 180px;
    width: 160px;
  }
  .cart {
    border: 1px solid;
    padding: 10px;
  }
  .cart-item {
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
  }
  .cart-item span {
    margin-right: 10px;
  }
</style>
<div class="pagetitle">
  <h1>POINT OF SALE</h1>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">MOVIE AVAILABLE</h5>
          <div class="movie-grid">
<?php 
$i = 1;
$movie = $conn->query("SELECT * FROM tbl_movie_info");
while ($row = $movie->fetch_assoc()) {
  $movie_invnt = $conn->query("SELECT * FROM tbl_movie_inventory_info WHERE `tbl_movie_info_id` = " . $row['id']);
  while ($rows = $movie_invnt->fetch_assoc()) {
    $data_about2 = $conn->query("SELECT SUM(requestedQty) AS totalRequestedQty FROM tbl_rents_info WHERE `status` = 'RENTED' AND `tbl_movie_info_id` = " . $row['id']);
    if ($data_about2) {
      $row_about2 = $data_about2->fetch_assoc();
      $totalRequestedQty = $row_about2['totalRequestedQty'];
    } else {
      $totalRequestedQty = 0;
    }

    $available = intval($rows['available']) - intval($totalRequestedQty);
    if ($available > 0) {
      ?>
      <div class="movie-item" onclick="addToCart(
        '<?php echo $row['id'] ?>', 
        '<?php echo $row['title'] ?>',  
        '<?php echo $rows['price'] ?>'
        )">
        <img class="grid_pic" src="<?php echo $row['img'] ?>"><br>
        <?php echo $row['title'] ?>
      </div>
      <?php
    }
  }
}
?>

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title"><?php echo $name?> <br><span>Seller </span> <span id="current-time"></span> <span id="current-date"></span></h5>
          <form action="" id="manage-cart" class="row g-3 needs-validation" novalidate>
            <div class="row">
              <div class="col-6">
                <input type="hidden" name="seller" value="'<?php echo $_SESSION['login_id'] ?>'">
                <label for="Customer">Customer:</label>
                <select name="customer" class="form-control" id="customer" required>
                  <option value="" selected>Select Customer Here</option>
                  <?php 
                  $customers = $conn->query("SELECT * FROM tbl_customer_info order by lName asc");
                  if($customers->num_rows > 0):
                    while($row= $customers->fetch_assoc()) :
                      ?>
                      <option value="<?php echo $row['id'] ?>">
                        <?php echo ucwords($row['fName']." ".$row['mName'][0].". ".$row['lName']) ?>
                      </option>
                    <?php endwhile; ?>
                  <?php else: ?>
                    <option selected="" value="" disabled="">Please check the Customer list.</option>
                  <?php endif; ?>
                </select>
              </div>
              <div class="col-6">
                <label for="requestedDate">Return Date:</label>
                <input class="form-control" type="date" name="requestedDate" id="requestedDate"required><br>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="cart">
              <h2>Cart</h2>
              <div id="cartItems">
              </div>
              <div>
                <h3>Total: <span id="totalPrice">0.00</span></h3>
              </div>
            </div>
            <div class="card-footer">
              <input type="hidden" name="cart" id="cartsu">
              <button class="btn btn-sm btn-primary col-sm-6 offset-md-6"> Process Transaction</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    function updateTime() {
      var date = new Date();
      var time = date.toLocaleTimeString();
      var dateStr = date.toDateString();
      document.getElementById('current-time').innerHTML = "| "+time;
      document.getElementById('current-date').innerHTML = "| "+dateStr;
    }
    setInterval(updateTime, 1000);
  </script>
  <script>
    let cart = [];
    function addToCart(id, title, price) {
      const existingItem = cart.find(item => item.id === id);
      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        cart.push({
          id,
          title,
          price,
          quantity: 1,
        });
      }
      updateCart();
    }
    function removeFromCart(id) {
      const existingItemIndex = cart.findIndex(item => item.id === id);
      if (existingItemIndex !== -1) {
        cart[existingItemIndex].quantity -= 1;
        if (cart[existingItemIndex].quantity === 0) {
          cart.splice(existingItemIndex, 1);
        }
      }
      updateCart();
    }
    function updateCart() {
      const cartItemsElement = document.getElementById('cartItems');
      const totalPriceElement = document.getElementById('totalPrice');
      cartItemsElement.innerHTML = '';
      let totalPrice = 0;
      cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        totalPrice += itemTotal;
        const cartItemElement = document.createElement('div');
        cartItemElement.classList.add('cart-item');
        cartItemElement.innerHTML = `
        <span>${item.title} - Php ${item.price}</span>
        <span>Quantity: ${item.quantity}</span>
        <a onclick="removeFromCart('${item.id}')"style="cursor: pointer; color: red; text-decoration: none; font-weight: bold; background-color: #0d6efd; padding: 2px 5px; border-radius: 4px;">X</a>
        `;
        cartItemsElement.appendChild(cartItemElement);
      });
      totalPriceElement.textContent = `${totalPrice.toFixed(2)}`;
      const myJSON = JSON.stringify(cart);
      document.getElementById("cartsu").value='';
      document.getElementById("cartsu").value=myJSON;
    }
    $('#requestedDate').val(new Date().toISOString().slice(0, 10));
    $('#manage-cart').submit(function(e){
      e.preventDefault()
      var customer_select = document.getElementById('customer').value;
      var requestedDate_selecteq = document.getElementById('requestedDate').value;
      var carts = document.getElementById('cartsu').value;
      if (customer_select == "" || requestedDate_selecteq=="" || carts=="" ) {
        alert('Complete the Information');
      }else{
        $.ajax({
          url:'ajax.php?action=save_trans',
          data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success:function(resp){
            if(resp==1){
              // Show the modal
              $('#success_rented').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
                $('#success_rented').modal('hide');
                location.reload()
              }, duration);
            }
          }
        })
      }
    });
  </script>
