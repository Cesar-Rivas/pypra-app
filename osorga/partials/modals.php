<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="withdraw-form">
      <div class="modal-header"><h5>Withdraw Item</h5></div>
      <div class="modal-body">
        <input type="hidden" name="item_id">
        <div class="mb-3">
          <label>Quantity</label>
          <input type="number" name="quantity" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger">Withdraw</button>
      </div>
    </form>
  </div>
</div>

<!-- Restock Modal -->
<div class="modal fade" id="restockModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="restock-form">
      <div class="modal-header"><h5>Restock Item</h5></div>
      <div class="modal-body">
        <input type="hidden" name="item_id">
        <div class="mb-3">
          <label>Quantity</label>
          <input type="number" name="quantity" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success">Restock</button>
      </div>
    </form>
  </div>
</div>
