@extends('backend.layouts.app')

{{-- website title --}}
@section('title','Orders')

{{-- website css --}}
@section('css')
<style></style>
@endsection

{{-- website body content --}}
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Report</h1>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('order.show') }}"><i class="fas fa-list"></i> Reports List</a>
  </div>
  
  <div class="alert alert-success" role="alert" style="display:none" id="alert-toggle">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="d-flex align-items-center justify-content-start">
      <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
      <span><strong>Success!  </strong><span id="alert-message"></span></span>
    </div>
  </div>

  <div class="row row-sm">
    <div class="col-lg-12 mg-t-20 mg-lg-t-0">
      <div class="card">
        <div class="card-body pb-0">
          <form id="orderForm">
            
            <div class="form-row">
              <div class="form-group col-md-3">
                <select name="category_id" class="form-control" id="categoryDropdown">
                  <option value="">Choose Category</option>
                  @if($categories)
                    @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group col-md-3">
                <select name="product_id" class="form-control" id="productDropdown">
                  <option value="">Choose Product</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <input type="hidden" class="form-control" id="productRealQty">
                <input type="number" class="form-control" id="productQty" placeholder="Qty">
              </div>
              <div class="form-group col-md-2">
                <input type="number" class="form-control" id="purchasePrice" placeholder="Purchase Price">
              </div>
              <div class="form-group col-md-2">
                <input type="number" class="form-control" id="salePrice" placeholder="Sale Price">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-3">
                <input type="text" class="form-control" id="expenseDetail" placeholder="Expense Detail">
              </div>
              <div class="form-group col-md-3">
                <input type="number" class="form-control" id="expense" placeholder="Expense">
              </div>
              <div class="form-group col-md-2">
                <input type="date" class="form-control" id="orderDate" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
              <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary" onclick="addOrder()">Add Order</button>
              </div>
            </div>
          
          </form>
        </div>
      </div>

      <div class="table-responsive-sm mt-3">
        <table class="table table-bordered text-center">
          <thead class="thead-light">
            <tr>
              <th>No</th>
              <th>Product</th>
              <th>Qty</th>
              <th>Purchase Price</th>
              <th>Sale Price</th>
              <th>Sub Total</th>
              <th>Status</th>
              <th>Expense</th>
              <th>Expense Detail</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
          <thead class="thead-light">
            <tr>
              <th colspan="2"><span>Report No. <span id="report_no"></span></span></th>
              <th>
                <small>(Qty)</small><br>
                <span id="total_qty"></span>
              </th>
              <th>
                <small>(Purchase Price)</small><br>
                Rs: <span id="total_purchase_price"></span>
              </th>
              <th>
                <small>(Sale Price)</small><br>
                Rs: <span id="total_sale_price"></span>
              </th>
              <th>
                <small>(Sub Total)</small><br>
                Rs: <span id="sub_total_sign"></span><span id="sub_total"></span>
              </th>
              <th>
                <small>(Sale Status)</small><br>
                <span id="sale_status">Profit</span>
              </th>
              <th>
                <small>(Expense)</small><br>
                Rs: -<span class="text-danger" id="total_expense"></span>
              </th>
              <th colspan="2">
                <small>(Net Total)</small><br>
                Rs: <span id="net_total_sign"></span><span id="net_total"></span>
              </th>
            </tr>
          </thead>
        </table>
      </div>
      <button type="button" class="btn btn-success" onclick="saveTodayOrders()">Save Today Report</button>
      <button type="button" class="btn btn-danger float-right" onclick="removeItemStorage()">Reset Report</button>
    </div>
  </div>

  <!-- Edit Order Modal -->
  <div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myLargeModalLabel">Edit Order</h5>
        </div>
        <div class="modal-body">

          <form id="editForm">
            <div class="form-row">
              <div class="form-group col-md-6">
                <select name="edit_category_id" class="form-control" id="editCategoryDropdown">
                  <option value="">Choose Category</option>
                  @if($categories)
                    @foreach($categories as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group col-md-6">
                <select name="edit_product_id" class="form-control" id="editProductDropdown">
                  <option value="">Choose Product</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <input type="number" class="form-control" id="editPurchasePrice" placeholder="Purchase Price">
              </div>
              <div class="form-group col-md-6">
                <input type="number" class="form-control" id="editSalePrice" placeholder="Sale Price">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <input type="number" class="form-control" id="editProductQty" placeholder="Qty">
              </div>
              <div class="form-group col-md-6">
                <input type="date" class="form-control" id="editOrderDate" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <input type="text" class="form-control" id="editExpenseDetail" placeholder="Expense Detail">
              </div>
              <div class="form-group col-md-6">
                <input type="number" class="form-control" id="editExpense" placeholder="Expense">
              </div>
            </div>
            <input type="hidden" id="editSlug" value="">
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" onClick="updateOrder()">Save Order</button>
        </div>
      </div>
    </div>
  </div>

@endsection

{{-- website js script --}}
@section('js')
<script>
  $(document).ready(function() {

    setTimeout(function() {
      // $(".alert").alert('close');
      $('#alert-toggle').hide();
    }, 3000);

    $('#categoryDropdown').on('change', function() {
      var category_id = $(this).val();
      if (category_id) {

        $.ajax({
          url : '{{route('order.fetch.products')}}',
          type: "POST",
          data: {'category_id':category_id, _token:"{{csrf_token()}}"},
          dataType: 'json',
          async: false,
          success: function(response){
            if (response.statusCode == 200) {
              $('#productDropdown').find('option').remove();
              $('#productDropdown').append(response.options);
            } else if (response.statusCode == 404) {
              console.log(response.message);
            }
          },
          error: function(){
            console.log('error in change category dropdown');
          }
        });

      } else {
        $('#productDropdown').text('');
      }

      $('#productQty').val('');
      $('#productRealQty').val('');
      $('#purchasePrice').val('');
      $('#salePrice').val('');
    });

    $('#productDropdown').on('change', function() {
      var product_id = $(this).val();
      if (product_id) {

        $('#productQty').val('');
        $('#productRealQty').val('');
        $('#purchasePrice').val('');
        $('#salePrice').val('');

        $.ajax({
          url : '{{route('order.product.detail')}}',
          type: "POST",
          data: {'product_id':product_id, _token:"{{csrf_token()}}"},
          dataType: 'json',
          async: false,
          success: function(response){
            if (response.statusCode == 200) {
              $('#purchasePrice').val(response.product.price);
              $('#productRealQty').val(response.product.quantity);

            } else if (response.statusCode == 404) {
              console.log(response.message);
            }
          },
          error: function(){
            console.log('error in change category dropdown');
          }
        });
      }
    });

    $('#editCategoryDropdown').on('change', function() {
      var category_id = $(this).val();
      if (category_id) {

        changeCategoryDropdown(category_id);
      } else {
        $('#editProductDropdown').text('');
        $('#editPurchasePrice').val('');
      }
    });

    $('#editProductDropdown').on('change', function() {
      var product_id = $(this).val();
      if (product_id) {

        $.ajax({
          url : '{{route('order.product.detail')}}',
          type: "POST",
          data: {'product_id':product_id, _token:"{{csrf_token()}}"},
          dataType: 'json',
          async: false,
          success: function(response){
            if (response.statusCode == 200) {
              $('#editPurchasePrice').val(response.product.price);

            } else if (response.statusCode == 404) {
              console.log(response.message);
            }
          },
          error: function(){
            console.log('error in change category dropdown');
          }
        });

      } else {
        $('#editPurchasePrice').val('');
      }
    });

  });

  function changeCategoryDropdown(category_id) {
    $.ajax({
      url : '{{route('order.fetch.products')}}',
      type: "POST",
      data: {'category_id':category_id, _token:"{{csrf_token()}}"},
      dataType: 'json',
      async: false,
      success: function(response){
        if (response.statusCode == 200) {
          $('#editProductDropdown').find('option').remove();
          $('#editProductDropdown').append(response.options);
        } else if (response.statusCode == 404) {
          console.log(response.message);
        }
      },
      error: function(){
        console.log('error in change category dropdown');
      }
    });
  }

  
  function addOrder() {  
    var category_id = validateField('categoryDropdown');
    var product_id = validateField('productDropdown');
    var product_qty = validateField('productQty');
    var product_real_qty = validateField('productRealQty');
    var purchase_price = validateField('purchasePrice');
    var sale_price = validateField('salePrice');
    var expense_detail = validateField('expenseDetail');
    var expense = validateField('expense');
    var order_date = validateField('orderDate');

    if (category_id == '' || category_id == null || category_id == undefined) {
      alert('Category field is required');
      return false;
    }
    if (product_id == '' || product_id == null || product_id == undefined) {
      alert('Product field is required');
      return false;
    }
    if (product_qty == '' || product_qty == null || product_qty == undefined) {
      alert('Product Quantity is required');
      return false;
    }
    if (product_real_qty == null) {
    } else if (parseInt(product_qty) > parseInt(product_real_qty)) {
      alert('Product out of stock, Available stock '+product_real_qty);
      return false;
    }
    if (purchase_price == '' || purchase_price == null || purchase_price == undefined) {
      alert('Purchase Price is required');
      return false;
    }
    if (sale_price == '' || sale_price == null || sale_price == undefined) {
      alert('Sale Price is required');
      return false;
    }
    if (order_date == '' || order_date == null || order_date == undefined) {
      alert('Order Date is required');
      return false;
    }

    var categoryName = document.getElementById('categoryDropdown').options[document.getElementById('categoryDropdown').selectedIndex].text;
    if (categoryName == '' || categoryName == 'Choose Category') {
      alert('Category Name is required');
      return false;
    }

    var productName = document.getElementById('productDropdown').options[document.getElementById('productDropdown').selectedIndex].text;
    if (productName == '' || productName == 'Choose Product') {
      alert('Product Name is required');
      return false;
    }

    if (category_id && product_id && product_qty && purchase_price && sale_price && order_date) {

      var order = new Object;
      order.slug = Date.now();
      order.category_id = category_id;
      order.category_name = categoryName;
      order.product_id = product_id;
      order.product_name = productName;
      order.qty = product_qty;
      order.real_qty = product_qty;
      order.purchase_price = purchase_price;
      order.sale_price = sale_price;

      if(parseFloat(purchase_price) < parseFloat(sale_price)) {
        order.sub_total = parseFloat(sale_price) - parseFloat(purchase_price);
        order.status = 'profit';
      } else if(parseFloat(purchase_price) > parseFloat(sale_price)) {
        order.sub_total = parseFloat(purchase_price) - parseFloat(sale_price);
        order.status = 'loss';
      } else if(parseFloat(purchase_price) == parseFloat(sale_price)) {
        order.sub_total = parseFloat(purchase_price) - parseFloat(sale_price);
        order.status = null;
      }
      order.order_date = order_date.substring(0, 4)+'-'+order_date.substring(4, 6)+'-'+order_date.substring(6, 8);
      order.expense_detail = expense_detail;
      order.expense = expense;
      
      addItemStorage(order);
      window.location.reload();
    } else {
      alert('Some fields are missing');
      return false;
    }
  }


  function addItemStorage(order) {
    var jsonObject = localStorage.getItem("orders-list");
    
    if (jsonObject && JSON.parse(jsonObject).length > 0) {
      var oldData = JSON.parse(jsonObject);
      oldData.push(order);

      var newData = JSON.stringify(oldData);
      localStorage.setItem("orders-list", newData);

    } else {
      var ordersList = new Array();
      ordersList.push(order);
      var jsonObject = JSON.stringify(ordersList);
      localStorage.setItem("orders-list", jsonObject);
    }
  }


  function getItemStorage() {
    var storeItems = localStorage.getItem("orders-list");
    var items = JSON.parse(storeItems);
    return items;
  }


  function removeItemStorage() {
    localStorage.removeItem("orders-list");
    window.location.reload();
  }


  function fetchOrderNo() {
    $.ajax({
      url : '{{route('order.fetch.number')}}',
      type: "GET",
      dataType: 'json',
      async: false,
      success: function(response){
        if (response.statusCode == 200) {
          var oldOrderNo = response.orderNo;
          var newOrderNo = parseInt(oldOrderNo) + 1;
          document.getElementById('report_no').innerText = newOrderNo;

        } else if (response.statusCode == 404) {
          document.getElementById('report_no').innerText = 1;
        }
      },
      error: function(){
        console.log('error in fetch order number');
      }
    });
  }
  fetchOrderNo();


  function loadTable() {
    var itemsList = getItemStorage();
    if (itemsList && itemsList.length > 0) {

      var table = itemsList.map((item, key)=>{

        var expense = item.expense===null?'-':item.expense;
        var expense_detail = item.expense_detail===null?'-':item.expense_detail;
        var count = parseInt(key) + 1;
        var status = item.status===null?'-':item.status;
        var sub_total = 0;
        if (status == 'profit') {
          sub_total = '<b>+'+item.sub_total+'</b>';
        } else if (status == 'loss') {
          sub_total = '<b>-'+item.sub_total+'</b>';
        } else if (status == null) {
          sub_total = '<b>0</b>';
        }
        return(`<tr>
            <td>${count}</td>
            <td><small>(${item.category_name})</small><br>${item.product_name}</td>
            <td>${item.qty}</td>
            <td>${item.purchase_price}</td>
            <td>${item.sale_price}</td>
            <td class="bg-light">${sub_total}</td>
            <td>${status}</td>
            <td class="text-danger">-${expense}</td>
            <td>${expense_detail}</td>
            <td>
              <button type="button" class="btn btn-outline-info btn-sm" onclick="editOrder(${item.slug})"><i class="fas fa-edit"></i></button>
              <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOrder(${item.slug})"><i class="fas fa-trash"></i></button>
            </td>
          </tr>`);
      }).join('');

      document.getElementById('tbody').innerHTML = table;
    }
  }
  loadTable();


  function getCalculations() {
    var itemsList = getItemStorage();
    if (itemsList && itemsList.length > 0) {

      var totalQty = 0;
      var totalPurchasePrice = 0;
      var totalSalePrice = 0;
      var subTotal = 0;
      var saleStatus = null;
      var totalExpense = 0;
      var netTotal = 0;

      itemsList.map((item, key)=>{
        totalQty = parseInt(totalQty) + parseInt(item.qty);
        totalPurchasePrice = parseInt(totalPurchasePrice) + parseInt(item.purchase_price);
        totalSalePrice = parseInt(totalSalePrice) + parseInt(item.sale_price);
        if (item.expense !== null) {
          totalExpense = parseInt(totalExpense) + parseInt(item.expense);
        }
      })

      var subTotalSign = '';
      if(parseFloat(totalSalePrice) > parseFloat(totalPurchasePrice)) {
        subTotal = parseFloat(totalSalePrice) - parseFloat(totalPurchasePrice);
        saleStatus = '<span class="text-success">profit</span>';
        subTotalSign = '+';
      } else if(parseFloat(totalPurchasePrice) > parseFloat(totalSalePrice)) {
        subTotal = parseFloat(totalPurchasePrice) - parseFloat(totalSalePrice);
        saleStatus = '<span class="text-danger">loss</span>';
        subTotalSign = '-';
      } else if(parseFloat(totalPurchasePrice) == parseFloat(totalSalePrice)) {
        subTotal = 0;
        saleStatus = '<span>-</span>';
        subTotalSign = '';
      }

      var netTotalSign = '';
      if (parseFloat(subTotal) !== NaN) {
        if (subTotalSign == '+') {
          netTotal = parseFloat(subTotal) - parseFloat(totalExpense);
        } else if (subTotalSign == '-') {
          netTotal = parseFloat(subTotal) + parseFloat(totalExpense);
          netTotalSign = '-';
        }
      }

      document.getElementById('total_qty').innerHTML = totalQty;
      document.getElementById('total_purchase_price').innerHTML = totalPurchasePrice;
      document.getElementById('total_sale_price').innerHTML = totalSalePrice;
      document.getElementById('sub_total_sign').innerHTML = subTotalSign;
      document.getElementById('sub_total').innerHTML = subTotal;
      document.getElementById('sale_status').innerHTML = saleStatus;
      document.getElementById('total_expense').innerHTML = totalExpense;
      document.getElementById('net_total').innerHTML = netTotal;
      document.getElementById('net_total_sign').innerHTML = netTotalSign;
    }
  }
  getCalculations();


  function totalCalculation() {
    var totalSlug = Date.now();
    var totalQty = document.getElementById('total_qty').innerText;
    var totalPurchasePrice = document.getElementById('total_purchase_price').innerText;
    var totalSalePrice = document.getElementById('total_sale_price').innerText;
    var subTotal = document.getElementById('sub_total').innerText;
    var saleStatus = document.getElementById('sale_status').innerText;
    var totalExpense = document.getElementById('total_expense').innerText;
    var netTotal = document.getElementById('net_total').innerText;

    if (totalQty && totalPurchasePrice && totalSalePrice && subTotal) {
      return({
        'slug': totalSlug,
        'total_product_quantity': totalQty,
        'total_purchase_price': totalPurchasePrice,
        'total_sale_price': totalSalePrice,
        'total_sub_total': subTotal,
        'sale_status': saleStatus,
        'total_expense': totalExpense,
        'net_total': netTotal
      });
    } else {
      return null;
    }
  }


  async function saveTodayOrders() {
    var totalCals = totalCalculation();
    var itemsList = getItemStorage();
    if (totalCals !== '' && itemsList && itemsList.length > 0) {
      var itemsListJson = localStorage.getItem("orders-list");
      var totalCalsJson = JSON.stringify(totalCals);

      await $.ajax({
        url : '{{route('order.list.save')}}',
        type: "POST",
        data: {'items':itemsListJson, 'total':totalCalsJson, _token:"{{csrf_token()}}"},
        dataType: 'json',
        success: async function(response){
          if (response.statusCode == 200) {

            // $('#alert-toggle').show();
            // document.getElementById('alert-message').innerHTML = response.message;
            alert(response.message);
            await new Promise(resolve => setTimeout(resolve, 1000));
            removeItemStorage();

          } else if (response.statusCode == 404) {
            console.log(response.message);
          }
        },
        error: function(){
          console.log('error in change category dropdown');
        }
      });

    } else {
      alert('Add some orders');
    }
  }

  
  function removeOrder(slug) {
    if (confirm('Are you sure want to delete?')) {
      var newList = new Array();
      var jsonObject = localStorage.getItem("orders-list");
      
      if (jsonObject && JSON.parse(jsonObject).length > 0) {
        var oldList = JSON.parse(jsonObject);
  
        oldList.map((item, key)=>{
          if (parseInt(item.slug) !== parseInt(slug)) {
            newList.push(item);
          }
        });
  
        localStorage.setItem("orders-list", JSON.stringify(newList));
        window.location.reload();
      }
    }
  }
  

  function editOrder(slug) {
    var searchOrder = new Array();
    var jsonObject = localStorage.getItem("orders-list");
    
    if (jsonObject && JSON.parse(jsonObject).length > 0) {
      var oldList = JSON.parse(jsonObject);

      oldList.map((item, key)=>{
        if (parseInt(item.slug) === parseInt(slug)) {
          searchOrder.push(item);
        }
      });

      if (searchOrder && searchOrder.length > 0) {
        $("#editModal").modal("show");

        searchOrder.map((order, key)=>{
          
          document.getElementById('editCategoryDropdown').value = order.category_id;
          changeCategoryDropdown(order.category_id);

          document.getElementById('editProductDropdown').value = order.product_id;
          document.getElementById('editPurchasePrice').value = order.purchase_price;
          document.getElementById('editSalePrice').value = order.sale_price;
          document.getElementById('editProductQty').value = order.qty;
          document.getElementById('editExpense').value = order.expense;
          document.getElementById('editExpenseDetail').value = order.expense_detail;
          document.getElementById('editOrderDate').value = order.order_date;
          document.getElementById('editSlug').value = order.slug;
        });
        
      }
    }
  }


  function updateOrder() { 
    var category_id = validateField('editCategoryDropdown');
    var product_id = validateField('editProductDropdown');
    var purchase_price = validateField('editPurchasePrice');
    var sale_price = validateField('editSalePrice');
    var product_qty = validateField('editProductQty');
    var expense = validateField('editExpense');
    var expense_detail = validateField('editExpenseDetail');
    var order_date = validateField('editOrderDate');
    var order_slug = validateField('editSlug');

    if (category_id == '' || category_id == null || category_id == undefined) {
      alert('Category field is required');
      return false;
    }
    if (product_id == '' || product_id == null || product_id == undefined) {
      alert('Product field is required');
      return false;
    }
    if (product_qty == '' || product_qty == null || product_qty == undefined) {
      alert('Product Quantity is required');
      return false;
    }
    if (purchase_price == '' || purchase_price == null || purchase_price == undefined) {
      alert('Purchase Price is required');
      return false;
    }
    if (sale_price == '' || sale_price == null || sale_price == undefined) {
      alert('Sale Price is required');
      return false;
    }
    if (order_date == '' || order_date == null || order_date == undefined) {
      alert('Order Date is required');
      return false;
    }

    var categoryName = document.getElementById('editCategoryDropdown').options[document.getElementById('editCategoryDropdown').selectedIndex].text;
    if (categoryName == '' || categoryName == 'Choose Category') {
      alert('Category Name is required');
      return false;
    }

    var productName = document.getElementById('editProductDropdown').options[document.getElementById('editProductDropdown').selectedIndex].text;
    if (productName == '' || productName == 'Choose Product') {
      alert('Product Name is required');
      return false;
    }

    if (category_id && product_id && product_qty && purchase_price && sale_price && order_date) {

      var order = new Object;
      order.slug = parseInt(order_slug)
      order.category_id = category_id;
      order.category_name = categoryName;
      order.product_id = product_id;
      order.product_name = productName;
      order.qty = product_qty;
      order.purchase_price = purchase_price;
      order.sale_price = sale_price;

      if(parseFloat(purchase_price) < parseFloat(sale_price)) {
        order.sub_total = parseFloat(sale_price) - parseFloat(purchase_price);
        order.status = 'profit';
      } else if(parseFloat(purchase_price) > parseFloat(sale_price)) {
        order.sub_total = parseFloat(purchase_price) - parseFloat(sale_price);
        order.status = 'loss';
      } else if(parseFloat(purchase_price) == parseFloat(sale_price)) {
        order.sub_total = parseFloat(purchase_price) - parseFloat(sale_price);
        order.status = null;
      }
      order.order_date = order_date.substring(0, 4)+'-'+order_date.substring(4, 6)+'-'+order_date.substring(6, 8);
      order.expense_detail = expense_detail;
      order.expense = expense;


      var editList = new Array();
      var jsonObject = localStorage.getItem("orders-list");
      
      if (jsonObject && JSON.parse(jsonObject).length > 0) {
        var oldList = JSON.parse(jsonObject);

        oldList.map((item, key)=>{
          if (parseInt(item.slug) === parseInt(order.slug)) {
            editList.push(order);
          } else {
            editList.push(item);
          }
        });

        localStorage.setItem("orders-list", JSON.stringify(editList));
        alert('update successfully');
        window.location.reload();
      }
    } else {
      alert('Some fields are missing');
      return false;
    }
  }


  function validateField(id) {
    var string = document.getElementById(id).value;
    string = string.replace(/[^a-zA-Z0-9]/g, "");
    string = string.trim();
    if (string) {
      return string;
    } else {
      return null;
    }
  }
</script>
@endsection
