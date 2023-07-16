<!-- Add Event -->
<div class="modal fade none-border" id="event-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
          <strong>Add New Event</strong>
        </h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
        <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- end add event model -->


<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-category">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <strong>Add a Usual Event </strong>
        </h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-6">
              <label class="control-label">Event Name <span style="color:red">*</span> </label>
              <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
            </div>
            <div class="col-md-6">
              <label class="control-label">Choose Category Color <span style="color:red">*</span> </label>
              <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                <option value="success">Green</option>
                <option value="danger">Red</option>
                <option value="info">Blue</option>
                <option value="pink">Pink</option>
                <option value="warning">Yellow</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL -->
