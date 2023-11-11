<!-- Button trigger modal -->
<button type="button" id="product-add" onclick="resetModal()" class="btn btn-primary" data-toggle="modal" data-target="#configModal">
  Add
</button>

    <!-- Modal -->
    <form method="post" action="#" id="configForm">
        <div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal domain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="url">Domain name</label>
                    <input type="text" class="form-control"  name="url" id="url" aria-describedby="" placeholder="Domain name">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="config-save" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>
    </form>