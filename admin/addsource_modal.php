
<!-- add NCP source URL -->
<div class="modal fade" id="addNcpSourceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Source URL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="functions.php" method="POST">
        <div class="modal-body">
          
            <div class="form-group" id ="display_id">
              <textarea name="sourcelink" rows="3" placeholder="Enter your source URL here" class="form-control" id="" required></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add_source_btn" class="btn btn-primary">Add Source</button>
        </div>
      </form>
     
    </div>
  </div>
</div>

<!-- add LCP source URL -->
<div class="modal fade" id="addLcpSourceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Source URL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="functions.php" method="POST">
        <div class="modal-body">
          
            <div class="form-group" id ="display_lssid">
              <textarea name="sourcelink" rows="3" placeholder="Enter your source URL here" class="form-control" id="" required></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add_source_lss" class="btn btn-primary">Add Source</button>
        </div>
      </form>
     
    </div>
  </div>
</div>